<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProduksiPerkebunan;
use App\Models\Kecamatan;
use App\Models\JenisTanaman;
use App\Models\Periode;



class ProduksiPerkebunanSeeder extends Seeder
{
    public function run()
{
    $kecamatans = Kecamatan::all();
    $periodes = Periode::all();
    $tanamans = JenisTanaman::all();

    foreach ($periodes as $periode) {
        foreach ($kecamatans as $kecamatan) {
            foreach ($tanamans as $tanaman) {
                ProduksiPerkebunan::create([
                    'kecamatan_id' => $kecamatan->id,
                    'periode_id' => $periode->id,
                    'jenis_tanaman_id' => $tanaman->id,
                    'produksi_ton' => rand(0, 200),
                ]);
            }
        }
    }
}

}
		