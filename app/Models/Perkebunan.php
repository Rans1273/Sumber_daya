<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perkebunan extends Model
{
    use HasFactory;

    // Menetapkan nama tabel
    protected $table = 'produksi_perkebunan';

    // Tentukan kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'kecamatan', 'kelapa', 'kopi', 'kakao', 'tebu', 'tembakau',
    ];
}

