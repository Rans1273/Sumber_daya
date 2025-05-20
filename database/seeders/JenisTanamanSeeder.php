<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisTanaman;

class JenisTanamanSeeder extends Seeder
{
    public function run()
    {
        $tanamans = ['Kelapa', 'Kopi', 'Kakao', 'Tebu', 'Tembakau'];

        foreach ($tanamans as $nama) {
            JenisTanaman::create(['nama' => $nama]);
        }
    }
}
