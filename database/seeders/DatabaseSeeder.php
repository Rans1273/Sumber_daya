<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kecamatan;
use App\Models\ProduksiPerkebunan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        JenisTanamanSeeder::class,
    ]);

    $this->call([
        KecamatanSeeder::class,
    ]);

    $this->call([
        PeriodeSeeder::class,
    ]);

    $this->call([
        ProduksiPerkebunanSeeder::class,
    ]);

}

}
