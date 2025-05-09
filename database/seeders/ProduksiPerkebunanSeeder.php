<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduksiPerkebunanSeeder extends Seeder
{
    public function run()
    {
        $kecamatan = [
            'Tanjung Palas', 
            'Tanjung Palas Tengah', 
            'Tanjung Palas Timur', 
            'Tanjung Palas Barat', 
            'Tanjung Palas Hulu', 
            'Tanjung Selor', 
            'Sekatak', 
            'Bunyu', 
            'Peso' // Tanpa "Tanjung Palas Utara"
        ];

        foreach ($kecamatan as $nama) {
            DB::table('produksi_perkebunan')->insert([
                'kecamatan' => $nama,
                'kelapa' => rand(100, 1000),
                'kopi' => rand(100, 1000),
                'kakao' => rand(100, 1000),
                'tebu' => rand(100, 1000),
                'tembakau' => rand(100, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
