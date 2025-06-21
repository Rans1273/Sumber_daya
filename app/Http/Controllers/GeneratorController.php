<?php

// app/Http/Controllers/GeneratorController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GeneratorController extends Controller
{
    /**
     * Menampilkan halaman form generator tabel.
     */
    public function showTableGenerator()
    {
        return view('generator.table'); // Kita akan buat view ini di langkah berikutnya
    }

    /**
     * Membuat file migrasi berdasarkan input dari form.
     */
    public function generateTable(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'table_name' => 'required|string',
            'columns' => 'required|array',
            'columns.*.name' => 'required|string',
            'columns.*.type' => 'required|string',
        ]);

        // 2. Format nama tabel (e.g., "Data Industri" -> "data_industris")
        $tableName = Str::snake(Str::plural($request->table_name));
        $className = 'Create' . Str::studly($tableName) . 'Table';

        // 3. Buat konten untuk file migrasi
        $migrationContent = $this->createMigrationContent($tableName, $className, $request->columns);

        // 4. Buat nama file migrasi dengan timestamp
        $fileName = date('Y_m_d_His') . '_create_' . $tableName . '_table.php';
        $filePath = database_path('migrations/' . $fileName);

        // 5. Simpan file migrasi
        File::put($filePath, $migrationContent);

        // 6. Kembalikan response ke user
        return redirect()->back()->with('success', "File migrasi '{$fileName}' berhasil dibuat. Silakan jalankan 'php artisan migrate'.");
    }

    /**
     * Helper untuk membuat string konten file migrasi.
     */
    private function createMigrationContent($tableName, $className, $columns)
    {
        $fields = "";
        foreach ($columns as $column) {
            $colName = Str::snake($column['name']);
            $colType = $column['type'];
            // Tambahkan '$table->' di setiap baris dan tipe kolom
            $fields .= "\$table->{$colType}('{$colName}');\n\t\t\t";
        }

        return <<<EOD
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class {$className} extends Migration
{
    public function up()
    {
        Schema::create('{$tableName}', function (Blueprint \$table) {
            \$table->id();
            {$fields}\$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$tableName}');
    }
}
EOD;
    }
}