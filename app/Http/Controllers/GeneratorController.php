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
        $tables = collect(DB::select('SHOW TABLES'))->map(fn($table) => reset($table))->sort()->values();
        $dinas = DB::table('dinas')->orderBy('nama')->get();
        return view('generator.table', ['dinas' => $dinas, 'tables' => $tables]);
    }

    /**
     * Titik masuk utama untuk memproses kedua jenis generator.
     */
    public function generate(Request $request)
    {
        // 1. Validasi dasar
        $request->validate([
            'generator_type' => 'required|in:master,transactional',
            'page_name' => 'required|string|max:255',
        ]);

        $type = $request->generator_type;
        $pageName = $request->page_name;
        $modelName = Str::studly(Str::singular($pageName));
        $tableName = Str::snake(Str::plural($pageName));

        if (Schema::hasTable($tableName)) {
            return redirect()->back()->withErrors("GAGAL: Tabel '{$tableName}' sudah ada.")->withInput();
        }

        try {
            // Logika untuk Generator Master
            if ($type === 'master') {
                $request->validate([ 'columns' => 'required|array|min:1' ]);
                $this->createAndRunMigration($tableName, $request->columns, []);
                $this->createModel($modelName, $tableName, $request->columns, []);
                $successMessage = "Generator Master berhasil: Tabel '{$tableName}' dan Model '{$modelName}.php' dibuat.";
            
            // Logika untuk Generator Tabel Utama
            } else { // transactional
                $request->validate([
                    'dinas_id' => 'required|exists:dinas,id',
                    'value_columns' => 'required|array|min:1',
                    'relations' => 'required|array|min:1',
                ]);

                $columns = $request->value_columns;
                $relations = $request->relations;
                $controllerName = $modelName . 'Controller';
                $routeName = Str::kebab(Str::plural($pageName));
                $selectedDinas = DB::table('dinas')->find($request->dinas_id);
                $dinasFolderName = Str::snake($selectedDinas->nama);
                $viewFileName = Str::snake($pageName);

                $this->createAndRunMigration($tableName, $columns, $relations);
                $this->createModel($modelName, $tableName, $columns, $relations);
                $this->createController($controllerName, $modelName, $dinasFolderName, $viewFileName, $routeName, $relations);
                $this->createViewsForTransactional($dinasFolderName, $viewFileName, $pageName, $routeName, $columns, $relations);
                $this->addRoute($routeName, $controllerName);
                
                $successMessage = "Generator Tabel Utama berhasil dijalankan untuk '{$pageName}'.";
            }

        } catch (Exception $e) {
            $this->cleanupFailedMigration($tableName);
            return redirect()->back()->withErrors('TERJADI ERROR: ' . $e->getMessage() . ' di file ' . $e->getFile() . ' baris ' . $e->getLine())->withInput();
        }

        return redirect()->route('generator.show')->with('success', $successMessage);
    }

    // --- FUNGSI-FUNGSI PEMBANTU (HELPER METHODS) ---

    private function createAndRunMigration($tableName, $columns, $relations)
    {
        $className = 'Create' . Str::studly($tableName) . 'Table';
        $migrationFileName = date('Y_m_d_His') . '_create_' . $tableName . '_table.php';
        $fields = "            \$table->id();\n";
        foreach ($relations as $relation) {
            $foreignTableName = $relation['references'];
            $foreignKeyColumn = Str::snake(Str::singular($foreignTableName)) . '_id';
            $fields .= "            \$table->foreignId('{$foreignKeyColumn}')->constrained('{$foreignTableName}')->onDelete('cascade');\n";
        }
        foreach ($columns as $column) {
            $fields .= "            \$table->{$column['type']}('" . Str::snake($column['name']) . "')->nullable();\n";
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

    private function createController($controllerName, $modelName, $dinasFolderName, $viewFileName, $routeName, $relations)
    {
        $template = file_get_contents(app_path('Generators/stubs/controller.transactional.stub'));
        $useStatements = "use App\\Models\\{$modelName};\n";
        $withRelations = [];
        $compactsForForms = [];
        $formVariables = "";
        foreach ($relations as $relation) {
            $relatedModel = Str::studly(Str::singular($relation['references']));
            $variableName = Str::plural($relation['name']);
            $useStatements .= "use App\\Models\\{$relatedModel};\n";
            $withRelations[] = "'" . $relation['name'] . "'";
            $compactsForForms[] = "'$variableName'";
            $formVariables .= "        \${$variableName} = {$relatedModel}::orderBy('nama')->get();\n";
        }
        $content = str_replace(
            ['{{controllerName}}', '{{modelName}}', '{{useStatements}}', '{{viewPath}}', '{{routeName}}', '{{withRelations}}', '{{compactsForForms}}', '{{formVariables}}'],
            [$controllerName, $modelName, $useStatements, $dinasFolderName . '.' . $viewFileName, $routeName, implode(', ', $withRelations), implode(', ', $compactsForForms), $formVariables],
            $template
        );
        File::put(app_path("Http/Controllers/{$controllerName}.php"), $content);
    }
    
    private function createViewsForTransactional($dinasFolderName, $viewFileName, $pageName, $routeName, $columns, $relations)
    {
        $viewFolderPath = resource_path('views/' . $dinasFolderName);
        if (!File::isDirectory($viewFolderPath)) File::makeDirectory($viewFolderPath, 0755, true, true);
        $this->createIndexView($viewFolderPath, $viewFileName, $pageName, $routeName, $columns, $relations);
        $this->createFormView($viewFolderPath, $viewFileName, $pageName, $routeName, $columns, $relations, 'create');
        $this->createFormView($viewFolderPath, $viewFileName, $pageName, $routeName, $columns, $relations, 'edit');
    }

    private function createIndexView($viewFolderPath, $viewFileName, $pageName, $routeName, $columns, $relations)
    {
        $template = file_get_contents(app_path('Generators/stubs/view.transactional.index.stub'));
        $title = Str::title($pageName);
        $tableHeaders = "<th>No</th>\n";
        $tableBody = "<td>{{ \$loop->iteration }}</td>\n";
        foreach ($relations as $relation) {
            $tableHeaders .= "               <th>" . Str::title($relation['name']) . "</th>\n";
            $tableBody .= "                  <td>{{ \$record->{$relation['name']}->nama ?? '-' }}</td>\n";
        }
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

    private function createFormView($viewFolderPath, $viewFileName, $pageName, $routeName, $columns, $relations, $mode = 'create')
    {
        $template = file_get_contents(app_path("Generators/stubs/view.transactional.form.stub"));
        $title = Str::title($pageName);
        $formFields = "";
        foreach ($relations as $relation) {
            $relationName = $relation['name'];
            $variableName = Str::plural($relationName);
            $foreignKey = Str::snake(Str::singular($relation['references'])) . '_id';
            $displayColumn = $relation['display_column']; // Mengambil kolom display dari request
            $selected = $mode === 'edit' ? "{{ \$data->{$foreignKey} == \${$relationName}->id ? 'selected' : '' }}" : '';
            $formFields .= $this->generateDropdownField($foreignKey, $relationName, $variableName, $selected, $displayColumn);
        }
        foreach ($columns as $column) {
            $columnName = Str::snake($column['name']);
            $value = $mode === 'edit' ? "value=\"{{ old('{$columnName}', \$data->{$columnName}) }}\"" : "value=\"{{ old('{$columnName}') }}\"";
            $formFields .= $this->generateInputField($columnName, $column['type'], $value);
        }
        $content = str_replace(
            ['{{title}}', '{{routeName}}', '{{formFields}}', '{{mode}}'],
            [$title, $routeName, $formFields, $mode],
            $template
        );
        File::put($viewFolderPath . "/{$viewFileName}-{$mode}.blade.php", $content);
    }
    
    private function generateDropdownField($foreignKey, $relationName, $variableName, $selected, $displayColumn)
    {
        $label = Str::title($relationName);
        // --- PERUBAHAN DI SINI ---
        // Menggunakan {{ $relationName->{$displayColumn} }} untuk fleksibilitas
        return "
        <div class=\"mb-3\">
            <label for=\"{$foreignKey}\" class=\"form-label\">{$label}</label>
            <select class=\"form-select\" name=\"{$foreignKey}\" id=\"{$foreignKey}\" required>
                <option value=\"\">-- Pilih {$label} --</option>
                @foreach (\${$variableName} as \${$relationName})
                    <option value=\"{{ \${$relationName}->id }}\" {$selected}>{{ \${$relationName}->{$displayColumn} }}</option>
                @endforeach
            </select>
        </div>";
    }
    public function getColumns($table)
        {
            try {
                if (!Schema::hasTable($table)) {
                    return response()->json(['error' => 'Tabel tidak ditemukan'], 404);
                }
                $columns = Schema::getColumnListing($table);
                return response()->json($columns);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

    private function generateInputField($columnName, $type, $value) {
        $label = Str::title(str_replace('_', ' ', $columnName));
        $inputType = 'text';
        if ($type === 'integer' || $type === 'decimal') $inputType = 'number';
        if ($type === 'date') $inputType = 'date';
        if ($type === 'text') return "<div class=\"mb-3\"><label for=\"{$columnName}\" class=\"form-label\">{$label}</label><textarea class=\"form-control\" id=\"{$columnName}\" name=\"{$columnName}\" rows=\"3\" required>{{ old('{$columnName}', \$data->{$columnName} ?? '') }}</textarea></div>";
        return "
        <div class=\"mb-3\">
            <label for=\"{$columnName}\" class=\"form-label\">{$label}</label>
            <input type=\"{$inputType}\" class=\"form-control\" id=\"{$columnName}\" name=\"{$columnName}\" {$value} required>
        </div>";
    }

    /**
     * Method untuk menambahkan Route ke web.php.
     * VERSI BARU: Membuat rute secara eksplisit.
     */
    private function addRoute($routeName, $controllerName)
    {
        $controllerClass = "App\\Http\\Controllers\\{$controllerName}::class";
        $routeContent = "
// Rute untuk {$controllerName}
Route::get('/{$routeName}', [{$controllerClass}, 'index'])->name('{$routeName}.index');
Route::get('/{$routeName}/create', [{$controllerClass}, 'create'])->name('{$routeName}.create');
Route::post('/{$routeName}', [{$controllerClass}, 'store'])->name('{$routeName}.store');
Route::get('/{$routeName}/{id}/edit', [{$controllerClass}, 'edit'])->name('{$routeName}.edit');
Route::put('/{$routeName}/{id}', [{$controllerClass}, 'update'])->name('{$routeName}.update');
Route::delete('/{$routeName}/{id}', [{$controllerClass}, 'destroy'])->name('{$routeName}.destroy');
// Catatan: Rute kustom seperti upload CSV atau destroy dengan parameter ganda
// perlu ditambahkan secara manual di routes/web.php jika diperlukan.
";
        File::append(base_path('routes/web.php'), $routeContent);
    }

    private function cleanupFailedMigration($tableName)
    {
        $migrationFiles = File::glob(database_path('migrations/*_create_' . $tableName . '_table.php'));
        foreach ($migrationFiles as $file) File::delete($file);
    }
}
