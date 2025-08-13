<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biji extends Model
{
    use HasFactory;

    protected $table = 'bijis';
    protected $fillable = ['nama_biji'];


}
