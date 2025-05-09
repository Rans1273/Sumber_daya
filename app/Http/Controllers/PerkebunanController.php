<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerkebunanController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('produksi_perkebunan');

        if ($request->filled('column') && $request->filled('search')) {
            $query->where($request->column, 'LIKE', '%' . $request->search . '%');
        }

        $data = $query->get();

        return view('contohtabel', compact('data'));
    }

    public function create()
    {
        return view('adddata'); // Pastikan nama file view sesuai (adddata.blade.php)
    }

    public function store(Request $request)
    {
        DB::table('produksi_perkebunan')->insert([
            'kecamatan' => $request->kecamatan,
            'kelapa' => $request->kelapa,
            'kopi' => $request->kopi,
            'kakao' => $request->kakao,
            'tebu' => $request->tebu,
            'tembakau' => $request->tembakau,
        ]);

        return redirect()->route('perkebunan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function uploadCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));

        // Validasi jumlah kolom header
        foreach ($data as $index => $row) {
            if (count($row) !== 6) {
                return back()->withErrors(['csv_file' => 'Format CSV tidak sesuai pada baris ke-' . ($index + 1)]);
            }
        }

        foreach ($data as $row) {
            DB::table('produksi_perkebunan')->insert([
                'kecamatan' => $row[0],
                'kelapa' => $row[1],
                'kopi' => $row[2],
                'kakao' => $row[3],
                'tebu' => $row[4],
                'tembakau' => $row[5],
            ]);
        }

        return redirect()->route('perkebunan.index')->with('success', 'Data CSV berhasil diupload');
    }

    public function edit($id)
    {
        $data = DB::table('produksi_perkebunan')->where('id', $id)->first();
        return view('editdata', compact('data'));
    }

    public function update(Request $request, $id)
    {
        DB::table('produksi_perkebunan')->where('id', $id)->update([
            'kecamatan' => $request->kecamatan,
            'kelapa' => $request->kelapa,
            'kopi' => $request->kopi,
            'kakao' => $request->kakao,
            'tebu' => $request->tebu,
            'tembakau' => $request->tembakau,
        ]);

        return redirect()->route('perkebunan.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        DB::table('produksi_perkebunan')->where('id', $id)->delete();
        return redirect()->route('perkebunan.index')->with('success', 'Data berhasil dihapus');
    }
}
