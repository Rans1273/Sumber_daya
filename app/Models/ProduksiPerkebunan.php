<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiPerkebunan extends Model {
    protected $fillable = [
        'kecamatan_id', 'periode_id', 'jenis_tanaman_id', 'produksi_ton'
    ];

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class);
    }

    public function jenisTanaman() {
        return $this->belongsTo(JenisTanaman::class);
    }
    public function periode() {
        return $this->belongsTo(Periode::class);
    }
}

