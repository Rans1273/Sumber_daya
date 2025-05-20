<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kecamatan;


class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $kecamatan = [
        'Tanjung Selor', 'Tanjung Palas', 'Tanjung Palas Barat', 'Tanjung Palas Timur',
        'Tanjung Palas Tengah', 'Tanjung Palas Utara',
        'Peso', 'Peso Hilir', 'Sekatak', 'Bunyu'
    ];

    foreach ($kecamatan as $nama) {
        Kecamatan::create(['nama' => $nama]);
    }
}

}
