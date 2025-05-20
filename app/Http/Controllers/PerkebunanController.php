<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\JenisTanaman;
use App\Models\Periode;
use App\Models\ProduksiPerkebunan;
use Illuminate\Http\Request;

class PerkebunanController extends Controller
{
    public function index(Request $request)
    {
        $query = ProduksiPerkebunan::with(['kecamatan', 'jenisTanaman', 'periode']);

        // Tambahkan filter jika form dikirim
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
                // Filter berdasarkan jenis tanaman (kelapa, kopi, dll)
                $query->whereHas('jenisTanaman', function ($q) use ($column) {
                    $q->whereRaw('LOWER(nama) = ?', [strtolower($column)]);
                })->where('produksi_ton', 'like', '%' . $search . '%');
            }
        }

        $data = $query->get();

        // Kelompokkan berdasarkan kombinasi kecamatan + periode
        $grouped = $data->groupBy(function ($item) {
            return $item->kecamatan_id . '-' . $item->periode_id;
        });

        $results = [];

        foreach ($grouped as $group) {
            $first = $group->first();
            $row = [
                'kecamatan' => $first->kecamatan->nama ?? '-',
                'tahun' => $first->periode->tahun ?? '-',
                'triwulan' => $first->periode->triwulan ?? '-',
                'produksi' => [],
                'id' => $first->id,
                'kecamatan_id' => $first->kecamatan_id,
                'periode_id' => $first->periode_id,
            ];


            foreach ($group as $item) {
                $row['produksi'][strtolower($item->jenisTanaman->nama)] = $item->produksi_ton;
            }

            $results[] = $row;
        }

        $kecamatanList = Kecamatan::pluck('nama')->unique();
        $tahunList = Periode::pluck('tahun')->unique();
        $triwulanList = Periode::pluck('triwulan')->unique();
        return view('contohtabel', compact('results', 'kecamatanList', 'tahunList', 'triwulanList'));
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
