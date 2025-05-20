<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run()
    {
        for ($tahun = 2022; $tahun <= 2025; $tahun++) {
            foreach (['I', 'II', 'III', 'IV'] as $triwulan) {
            Periode::create(['tahun' => $tahun, 'triwulan' => $triwulan]);
            }
        }
    }
}
