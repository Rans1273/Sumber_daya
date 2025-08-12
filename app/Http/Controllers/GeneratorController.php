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
                $request->validate([
                    'columns' => 'required|array|min:1',
                    'columns.*.name' => 'required|string|regex:/^[a-zA-Z0-9_]+$/',
                ]);
                
                $this->createAndRunMigration($tableName, $request->columns, []);
                $this->createModel($modelName, $tableName, $request->columns, []);

                $successMessage = "Generator Master berhasil dijalankan:<br>" .
                                  "1. Tabel '{$tableName}' berhasil dibuat.<br>" .
                                  "2. Model '{$modelName}.php' berhasil dibuat.";

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
                
                $successMessage = "Generator Tabel Utama berhasil dijalankan:<br>" .
                                  "1. Tabel '{$tableName}' dibuat.<br>" .
                                  "2. Model '{$modelName}.php' dibuat.<br>" .
                                  "3. Controller '{$controllerName}.php' dibuat.<br>" .
                                  "4. Views (index, create, edit) dibuat.<br>" .
                                  "5. Route '{$routeName}' ditambahkan.";
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
        $stubFile = 'view.transactional.form.stub';
        $template = file_get_contents(app_path("Generators/stubs/{$stubFile}"));
        $title = Str::title($pageName);
        $formFields = "";

        foreach ($relations as $relation) {
            $relationName = $relation['name'];
            $variableName = Str::plural($relationName);
            $foreignKey = Str::snake(Str::singular($relation['references'])) . '_id';
            $selected = $mode === 'edit' ? "{{ \$data->{$foreignKey} == \${$relationName}->id ? 'selected' : '' }}" : '';
            $formFields .= $this->generateDropdownField($foreignKey, $relationName, $variableName, $selected);
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

    private function generateDropdownField($foreignKey, $relationName, $variableName, $selected) { /* ... */ return ""; }
    private function generateInputField($columnName, $type, $value) { /* ... */ return ""; }

    private function addRoute($routeName, $controllerName)
    {
        $route = "\n// Route untuk {$controllerName}\nRoute::resource('{$routeName}', App\\Http\\Controllers\\{$controllerName}::class);";
        File::append(base_path('routes/web.php'), $route);
    }

    private function cleanupFailedMigration($tableName)
    {
        $migrationFiles = File::glob(database_path('migrations/*_create_' . $tableName . '_table.php'));
        foreach ($migrationFiles as $file) File::delete($file);
    }
}