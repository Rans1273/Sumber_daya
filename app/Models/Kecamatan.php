<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model {
    protected $fillable = ['nama'];
    
    public function produksiPerkebunans() {
        return $this->hasMany(ProduksiPerkebunan::class);
    }
}

