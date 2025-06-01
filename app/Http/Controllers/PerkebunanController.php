<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\JenisTanaman;
use App\Models\Periode;
use App\Models\ProduksiPerkebunan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;         


class PerkebunanController extends Controller
{
    public function index(Request $request)
    {
        $query = ProduksiPerkebunan::with(['kecamatan', 'jenisTanaman', 'periode']);

        // --- BAGIAN FILTER ---
        if ($request->filled('column') && $request->filled('search')) {
            $column = $request->input('column');
            $search = $request->input('search');

            if ($column === 'kecamatan') {
                $query->whereHas('kecamatan', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                });
            } elseif ($column === 'tahun') {
                $query->whereHas('periode', function ($q) use ($search) {
                    $q->where('tahun', 'like', '%' . $search . '%');
                });
            } elseif ($column === 'triwulan') {
                $query->whereHas('periode', function ($q) use ($search) {
                    $q->where('triwulan', 'like', '%' . $search . '%');
                });
            } else {
                $query->whereHas('jenisTanaman', function ($q) use ($column) {
                    $q->where(function($subQuery) use ($column){
                        $subQuery->whereRaw('LOWER(REPLACE(nama, " ", "_")) = ?', [$column])
                                 ->orWhereRaw('LOWER(nama) = ?', [$column]);
                    });
                })->where('produksi_ton', 'like', '%' . $search . '%');
            }
        }

        $data = $query->orderBy('periode_id')->orderBy('kecamatan_id')->get(); // Tambahkan order by jika perlu
        $semuaJenisTanamanModels = JenisTanaman::orderBy('nama')->get();
        $namaTanamansDinamis = $semuaJenisTanamanModels->map(function ($tanaman) {
            return Str::slug($tanaman->nama, '_'); 
        })->unique()->values()->all();


        $grouped = $data->groupBy(function ($item) {
            return $item->kecamatan_id . '-' . $item->periode_id;
        });

        $results = [];

        foreach ($grouped as $groupKey => $groupItems) {
            $firstItem = $groupItems->first();
            if (!$firstItem) { 
                continue;
            }

            $row = [
                'kecamatan' => $firstItem->kecamatan->nama ?? '-',
                'tahun' => $firstItem->periode->tahun ?? '-',
                'triwulan' => $firstItem->periode->triwulan ?? '-',
                'produksi' => [], 
                'id' => $firstItem->id,
                'kecamatan_id' => $firstItem->kecamatan_id,
                'periode_id' => $firstItem->periode_id,
            ];
            foreach ($namaTanamansDinamis as $namaTanamanKey) {
                $row['produksi'][$namaTanamanKey] = '-'; // Nilai default jika tidak ada produksi
            }

            foreach ($groupItems as $item) {
                if ($item->jenisTanaman && $item->jenisTanaman->nama) {
                    $namaTanamanSaatIniKey = Str::slug($item->jenisTanaman->nama, '_');
                    if (array_key_exists($namaTanamanSaatIniKey, $row['produksi'])) {
                        $row['produksi'][$namaTanamanSaatIniKey] = $item->produksi_ton;
                    }
                }
            }
            $results[] = $row;
        }

        $kecamatanList = Kecamatan::orderBy('nama')->pluck('nama', 'nama')->all(); // Menggunakan nama sebagai value & key
        $tahunList = Periode::distinct()->orderBy('tahun', 'desc')->pluck('tahun', 'tahun')->all();
        $triwulanList = Periode::distinct()->orderBy('triwulan')->pluck('triwulan', 'triwulan')->all();

        $cropTypesForFilter = $semuaJenisTanamanModels->mapWithKeys(function ($tanaman) {
            $value = Str::slug($tanaman->nama, '_'); // 'kelapa_sawit'
            $displayName = $tanaman->nama;          // 'Kelapa Sawit'
            return [$value => $displayName];
        })->all();

        return view('contohtabel', compact( 
            'results', 
            'kecamatanList',
            'tahunList',
            'triwulanList',
            'namaTanamansDinamis', 
            'cropTypesForFilter'   
        ));
    }


    public function create()
    {

        $kecamatans = Kecamatan::all();
        $periodes = Periode::all();


        $kecamatanList = $kecamatans->pluck('nama')->unique()->sortDesc();

        // Ambil tahun unik 
        $tahunList = $periodes->pluck('tahun')->unique()->sortDesc();

        // Ambil triwulan uniky
        $triwulanList = $periodes->pluck('triwulan')->unique();

        return view('adddata', compact('kecamatans', 'tahunList', 'triwulanList', 'periodes', 'kecamatanList'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'tahun' => 'required|numeric',
            'triwulan' => 'required|in:I,II,III,IV',
            'produksi' => 'required|array',
        ]);

        $periode = Periode::firstOrCreate([
            'tahun' => $request->tahun,
            'triwulan' => $request->triwulan
        ]);

        foreach ($request->produksi as $nama_tanaman => $jumlah) {
            $jenis_tanaman = JenisTanaman::where('nama', $nama_tanaman)->first();
            if ($jenis_tanaman) {
                ProduksiPerkebunan::create([
                    'kecamatan_id' => $request->kecamatan_id,
                    'periode_id' => $periode->id,
                    'jenis_tanaman_id' => $jenis_tanaman->id,
                    'produksi_ton' => $jumlah,
                ]);
            }
        }

        return redirect()->route('perkebunan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function uploadCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));

        foreach ($data as $index => $row) {
            if (count($row) !== 5) {
                return back()->withErrors(['csv_file' => 'Format CSV tidak sesuai pada baris ke-' . ($index + 1)]);
            }

            $kecamatan = Kecamatan::where('nama', $row[0])->first();
            $jenis = JenisTanaman::where('nama', $row[1])->first();

            if (!$kecamatan || !$jenis) {
                return back()->withErrors(['csv_file' => 'Data tidak valid pada baris ke-' . ($index + 1)]);
            }

            ProduksiPerkebunan::create([
                'kecamatan_id' => $kecamatan->id,
                'jenis_tanaman_id' => $jenis->id,
                'tahun' => $row[2],
                'triwulan' => $row[3],
                'produksi_ton' => $row[4],
            ]);
        }

        return redirect()->route('perkebunan.index')->with('success', 'Data CSV berhasil diupload');
    }

    public function edit($id)
    {
        $data = ProduksiPerkebunan::with('periode')->findOrFail($id);
        $kecamatans = Kecamatan::all();
        $jenis_tanamans = JenisTanaman::all();
        return view('editdata', compact('data', 'kecamatans', 'jenis_tanamans'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'tahun' => 'required|integer',
            'triwulan' => 'required|in:I,II,III,IV',
            'produksi' => 'required|array',
            'produksi.*' => 'required|numeric|min:0',
        ]);

        // Ambil data utama perkebunan yang mau diupdate
        $data = ProduksiPerkebunan::findOrFail($id);

        // Ambil atau buat periode baru
        $periode = Periode::firstOrCreate([
            'tahun' => $request->tahun,
            'triwulan' => $request->triwulan,
        ]);

        foreach ($request->produksi as $jenis_tanaman_id => $jumlah) {
            $produksi = ProduksiPerkebunan::where('kecamatan_id', $request->kecamatan_id)
                ->where('periode_id', $periode->id)
                ->where('jenis_tanaman_id', $jenis_tanaman_id)
                ->first();

            if ($produksi) {
                $produksi->update([
                    'produksi_ton' => $jumlah,
                ]);
            } else {
            return redirect()->back()->withErrors("Data produksi untuk jenis tanaman ID $jenis_tanaman_id tidak ditemukan.");
            }
        }

        return redirect()->route('perkebunan.index')->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy($kecamatan_id, $periode_id)
    {
        // Hapus semua data berdasarkan kecamatan dan periode
        ProduksiPerkebunan::where('kecamatan_id', $kecamatan_id)
            ->where('periode_id', $periode_id)
            ->delete();

        return redirect()->route('perkebunan.index')->with('success', 'Data berhasil dihapus.');
    }

}
