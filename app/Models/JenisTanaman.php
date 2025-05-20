<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTanaman extends Model {
    use HasFactory;

    protected $table = 'jenis_tanamans'; 
    protected $fillable = ['nama'];

    public function produksiPerkebunans() {
        return $this->hasMany(ProduksiPerkebunan::class);
    }
}
