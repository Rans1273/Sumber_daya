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
     * -----------------------------------------------------------------
     * PENTING: Setiap kali Anda membuat tabel master baru, tambahkan
     * nama tabelnya ke dalam array ini agar bisa diedit.
     * -----------------------------------------------------------------
     */
    private $allowedTables = [
        'dinas',
        'kecamatans',
        'jenis_tanamans',
        'periodes',
        // 'nama_tabel_baru_anda',
    ];

    /**
     * Menampilkan halaman utama dan data dari tabel yang dipilih.
     */
    public function index(Request $request)
    {
        // Selalu dapatkan daftar tabel master untuk dropdown
        $allTables = collect(DB::select('SHOW TABLES'))->map(fn($table) => reset($table));
        $masterTables = $allTables->filter(fn($table) => in_array($table, $this->allowedTables))->sort()->values();

        $dataForView = [
            'masterTables' => $masterTables,
            'selectedTable' => null,
            'columns' => [],
            'records' => [],
        ];

        // Periksa apakah pengguna telah memilih tabel
        if ($request->has('table') && !empty($request->table)) {
            $selectedTable = $request->table;

            try {
                // Dapatkan model dan data yang sesuai
                $model = $this->getModelForTable($selectedTable);
                
                $dataForView['selectedTable'] = $selectedTable;
                $dataForView['records'] = $model->orderBy('id')->get();
                $dataForView['columns'] = $model->getFillable();

            } catch (Exception $e) {
                // Jika terjadi error, kembali ke halaman index dengan pesan error
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
            $modelClass = get_class($this->getModelForTable($table));
            $model = new $modelClass;
            
            $data = $request->only($model->getFillable());
            
            // Validasi sederhana (asumsi semua tabel punya kolom 'nama')
            $request->validate(['nama' => 'required|string|max:255']);

            $modelClass::create($data);

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
            
            $data = $request->only($model->getFillable());

            $request->validate(['nama' => 'required|string|max:255']);

            $record->update($data);

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

        // Aturan standar Laravel
        $modelName = Str::studly(Str::singular($table));

        // Pengecualian khusus untuk kasus 'dinas' -> 'dina'
        if (strtolower($table) === 'dinas') {
            $modelName = 'Dinas';
        }

        $modelClass = "App\\Models\\{$modelName}";

        if (!class_exists($modelClass)) {
            throw new Exception("Model '{$modelName}' tidak ditemukan untuk tabel '{$table}'. Pastikan model sudah dibuat.");
        }

        return new $modelClass;
    }
}
