<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Exception;

class GeneratorController extends Controller
{
    /**
     * Menampilkan halaman form generator.
     */
    public function showGeneratorForm()
    {
        // Mengambil semua nama tabel di database untuk pilihan relasi di form
        $tables = collect(DB::select('SHOW TABLES'))->map(function ($table) {
            return reset($table);
        })->sort()->values();

        $dinas = DB::table('dinas')->orderBy('nama')->get();
        return view('generator.table', ['dinas' => $dinas, 'tables' => $tables]);
    }

    /**
     * Titik masuk utama untuk memproses kedua jenis generator.
     */
    public function generate(Request $request)
    {
        // 1. Validasi dasar & tentukan tipe generator
        $request->validate([
            'generator_type' => 'required|in:master,transactional',
            'dinas_id' => 'required|exists:dinas,id',
            'page_name' => 'required|string|max:255',
        ]);

        $type = $request->generator_type;
        $columns = [];
        $relations = [];

        // 2. Validasi spesifik berdasarkan tipe & siapkan data
        if ($type === 'master') {
            $request->validate([
                'columns' => 'required|array|min:1',
                'columns.*.name' => 'required|string|regex:/^[a-zA-Z0-9_]+$/',
                'columns.*.type' => 'required|string',
            ]);
            $columns = $request->columns;
        } else { // transactional
            $request->validate([
                'value_columns' => 'required|array|min:1',
                'value_columns.*.name' => 'required|string|regex:/^[a-zA-Z0-9_]+$/',
                'value_columns.*.type' => 'required|string',
                'relations' => 'required|array|min:1',
                'relations.*.name' => 'required|string',
                'relations.*.references' => 'required|string',
            ]);
            // Untuk generator besar, 'columns' adalah 'value_columns'
            $columns = $request->value_columns;
            $relations = $request->relations;
        }

        // 3. Persiapan Nama & Path (sama untuk kedua tipe)
        $pageName = $request->page_name;
        $modelName = Str::studly(Str::singular($pageName));
        $tableName = Str::snake(Str::plural($pageName));
        $controllerName = $modelName . 'Controller';
        $routeName = Str::kebab(Str::plural($pageName));
        
        $selectedDinas = DB::table('dinas')->find($request->dinas_id);
        $dinasFolderName = Str::snake($selectedDinas->nama);
        $viewFileName = Str::snake($pageName);

        if (Schema::hasTable($tableName)) {
            return redirect()->back()->withErrors("GAGAL: Tabel '{$tableName}' sudah ada di database.")->withInput();
        }

        // 4. Proses Pembuatan File-file
        try {
            $this->createAndRunMigration($tableName, $columns, $relations);
            $msg1 = "1. Tabel '{$tableName}' berhasil dibuat.";

            $this->createModel($modelName, $tableName, $columns, $relations);
            $msg2 = "2. Model '{$modelName}.php' berhasil dibuat.";

            // Panggil generator dengan tipe yang sesuai
            $this->createController($type, $controllerName, $modelName, $dinasFolderName, $viewFileName, $routeName, $relations);
            $msg3 = "3. Controller untuk tipe '{$type}' ('{$controllerName}.php') berhasil dibuat.";
            
            $this->createView($type, $dinasFolderName, $viewFileName, $pageName, $routeName, $columns, $relations);
            $msg4 = "4. View untuk tipe '{$type}' ('{$viewFileName}.blade.php') berhasil dibuat.";
            
            $this->addRoute($routeName, $controllerName);
            $msg5 = "5. Route '{$routeName}' berhasil ditambahkan.";

        } catch (Exception $e) {
            // Rollback: Hapus file migrasi jika terjadi error
            $this->cleanupFailedMigration($tableName);
            return redirect()->back()->withErrors('TERJADI ERROR: ' . $e->getMessage() . ' di file ' . $e->getFile() . ' baris ' . $e->getLine())->withInput();
        }

        $successMessage = implode("<br>", [$msg1, $msg2, $msg3, $msg4, $msg5]);
        return redirect()->route('generator.show')->with('success', $successMessage);
    }

    private function createAndRunMigration($tableName, $columns, $relations)
    {
        $className = 'Create' . Str::studly($tableName) . 'Table';
        $migrationFileName = date('Y_m_d_His') . '_create_' . $tableName . '_table.php';
        
        $fields = "            \$table->id();\n";
        foreach ($columns as $column) {
            $fields .= "            \$table->{$column['type']}('" . Str::snake($column['name']) . "')->nullable();\n";
        }

        foreach ($relations as $relation) {
            $foreignTableName = $relation['references'];
            $foreignKeyColumn = Str::snake(Str::singular($foreignTableName)) . '_id';
            $fields .= "            \$table->foreignId('{$foreignKeyColumn}')->constrained('{$foreignTableName}')->onDelete('cascade');\n";
        }
        $fields .= "            \$table->timestamps();";

        $template = file_get_contents(app_path('Generators/stubs/migration.create.stub'));
        $content = str_replace(['{{className}}', '{{tableName}}', '{{fields}}'], [$className, $tableName, $fields], $template);
        
        File::put(database_path('migrations/' . $migrationFileName), $content);
        Artisan::call('migrate', ['--path' => 'database/migrations/'.$migrationFileName]);
    }

    private function createModel($modelName, $tableName, $columns, $relations)
    {
        $fillable = collect($columns)->pluck('name')->map(fn($item) => "'" . Str::snake($item) . "'");
        foreach ($relations as $relation) {
            $fillable->push("'" . Str::snake(Str::singular($relation['references'])) . "_id'");
        }

        $relationMethods = '';
        foreach ($relations as $relation) {
            $relationName = $relation['name'];
            $relatedModel = Str::studly(Str::singular($relation['references']));
            $relationMethods .= "\n    public function {$relationName}()\n    {\n        return \$this->belongsTo({$relatedModel}::class);\n    }\n";
        }
        
        $template = file_get_contents(app_path('Generators/stubs/model.stub'));
        $content = str_replace(
            ['{{modelName}}', '{{tableName}}', '{{fillable}}', '{{relationMethods}}'],
            [$modelName, $tableName, $fillable->implode(', '), $relationMethods],
            $template
        );
        File::put(app_path("Models/{$modelName}.php"), $content);
    }

    private function createController($type, $controllerName, $modelName, $dinasFolderName, $viewFileName, $routeName, $relations)
    {
        $stubPath = $type === 'master' 
            ? app_path('Generators/stubs/controller.master.stub') 
            : app_path('Generators/stubs/controller.transactional.stub');
        
        $template = file_get_contents($stubPath);

        $useStatements = "use App\\Models\\{$modelName};\n";
        $withRelations = [];
        $compactsForForms = [];
        foreach ($relations as $relation) {
            $relatedModel = Str::studly(Str::singular($relation['references']));
            $useStatements .= "use App\\Models\\{$relatedModel};\n";
            $withRelations[] = "'" . $relation['name'] . "'";
            $compactsForForms[] = "'" . Str::plural($relation['name']) . "'";
        }

        $content = str_replace(
            ['{{controllerName}}', '{{modelName}}', '{{useStatements}}', '{{viewPath}}', '{{routeName}}', '{{withRelations}}', '{{compactsForForms}}'],
            [$controllerName, $modelName, $useStatements, $dinasFolderName . '.' . $viewFileName, $routeName, implode(', ', $withRelations), implode(', ', $compactsForForms)],
            $template
        );
        File::put(app_path("Http/Controllers/{$controllerName}.php"), $content);
    }
    
    private function createView($type, $dinasFolderName, $viewFileName, $pageName, $routeName, $columns, $relations)
    {
        $viewFolderPath = resource_path('views/' . $dinasFolderName);
        if (!File::isDirectory($viewFolderPath)) {
            File::makeDirectory($viewFolderPath, 0755, true, true);
        }

        $stubPath = $type === 'master'
            ? app_path('Generators/stubs/view.master.stub')
            : app_path('Generators/stubs/view.transactional.stub');
        
        $template = file_get_contents($stubPath);
        
        $title = Str::title($pageName);
        $tableHeaders = "<th>No</th>\n";
        $tableBody = "<td>{{ \$loop->iteration }}</td>\n";

        // Headers dan Body untuk semua relasi (dimensi)
        foreach ($relations as $relation) {
            $tableHeaders .= "               <th>" . Str::title($relation['name']) . "</th>\n";
            $tableBody .= "                  <td>{{ \$record->{$relation['name']}->nama ?? '-' }}</td>\n";
        }
        // Headers dan Body untuk semua kolom nilai
        foreach ($columns as $column) {
            $tableHeaders .= "               <th>" . Str::title(str_replace('_', ' ', $column['name'])) . "</th>\n";
            $tableBody .= "                  <td>{{ \$record->" . Str::snake($column['name']) . " }}</td>\n";
        }
        $tableHeaders .= "               <th>Aksi</th>";
        
        $content = str_replace(
            ['{{title}}', '{{tableHeaders}}', '{{tableBody}}', '{{colspan}}', '{{routeName}}'],
            [$title, $tableHeaders, $tableBody, count($columns) + count($relations) + 2, $routeName],
            $template
        );

        File::put($viewFolderPath . '/' . $viewFileName . '.blade.php', $content);
    }

    private function addRoute($routeName, $controllerName)
    {
        $route = "\n// Route untuk {$controllerName}\nRoute::resource('{$routeName}', App\\Http\\Controllers\\{$controllerName}::class);";
        File::append(base_path('routes/web.php'), $route);
    }

    private function cleanupFailedMigration($tableName)
    {
        $migrationFiles = File::glob(database_path('migrations/*_create_' . $tableName . '_table.php'));
        foreach ($migrationFiles as $file) {
            File::delete($file);
        }
    }
}
