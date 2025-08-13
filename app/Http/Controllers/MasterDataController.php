<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Exception;

class MasterDataController extends Controller
{
    /**
     * DAFTAR PUTIH (WHITELIST) TABEL MASTER
     */
    private $allowedTables = [
        'dinas',
        'kecamatans',
        'jenis_tanamans',
        'periodes',
        'bijis',
    ];

    /**
     * Menampilkan halaman utama dan data dari tabel yang dipilih.
     */
    public function index(Request $request)
    {
        $allTables = collect(DB::select('SHOW TABLES'))->map(fn($table) => reset($table));
        $masterTables = $allTables->filter(fn($table) => in_array($table, $this->allowedTables))->sort()->values();

        $dataForView = [
            'masterTables' => $masterTables,
            'selectedTable' => null,
            'columns' => [],
            'records' => [],
        ];

        if ($request->has('table') && !empty($request->table)) {
            $selectedTable = $request->table;
            try {
                $model = $this->getModelForTable($selectedTable);
                $dataForView['selectedTable'] = $selectedTable;
                $dataForView['records'] = $model->orderBy('id')->get();
                $dataForView['columns'] = $model->getFillable();
            } catch (Exception $e) {
                return redirect()->route('master-data.index')->withErrors($e->getMessage());
            }
        }

        return view('master-data.index', $dataForView);
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request, $table)
    {
        try {
            $model = $this->getModelForTable($table);
            $modelClass = get_class($model);
            
            // --- VALIDASI DINAMIS ---
            $rules = [];
            foreach ($model->getFillable() as $column) {
                $rules[$column] = 'required|string|max:255'; // Aturan dasar, bisa disesuaikan
            }
            $validatedData = $request->validate($rules);
            // --- AKHIR VALIDASI DINAMIS ---

            $modelClass::create($validatedData);

            return redirect()->route('master-data.index', ['table' => $table])
                            ->with('success', 'Data berhasil ditambahkan.');

        } catch (Exception $e) {
            return redirect()->route('master-data.index', ['table' => $table])
                            ->withErrors('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Mengupdate data yang ada di database.
     */
    public function update(Request $request, $table, $id)
    {
        try {
            $model = $this->getModelForTable($table);
            $record = $model->findOrFail($id);
            
            // --- VALIDASI DINAMIS ---
            $rules = [];
            foreach ($model->getFillable() as $column) {
                $rules[$column] = 'required|string|max:255';
            }
            $validatedData = $request->validate($rules);
            // --- AKHIR VALIDASI DINAMIS ---

            $record->update($validatedData);

            return redirect()->route('master-data.index', ['table' => $table])
                             ->with('success', 'Data berhasil diperbarui.');

        } catch (Exception $e) {
            return redirect()->route('master-data.index', ['table' => $table])
                             ->withErrors('Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy($table, $id)
    {
        try {
            $modelClass = get_class($this->getModelForTable($table));
            $modelClass::destroy($id);

            return redirect()->route('master-data.index', ['table' => $table])
                             ->with('success', 'Data berhasil dihapus.');

        } catch (Exception $e) {
            return redirect()->route('master-data.index', ['table' => $table])
                             ->withErrors('Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk mendapatkan instance Model dari nama tabel.
     */
    private function getModelForTable($table)
    {
        if (!in_array($table, $this->allowedTables)) {
            throw new Exception("Akses ke tabel '{$table}' tidak diizinkan.");
        }

        $modelName = Str::studly(Str::singular($table));
        if (strtolower($table) === 'dinas') {
            $modelName = 'Dinas';
        }
        $modelClass = "App\\Models\\{$modelName}";

        if (!class_exists($modelClass)) {
            throw new Exception("Model '{$modelName}' tidak ditemukan untuk tabel '{$table}'.");
        }

        return new $modelClass;
    }
}
