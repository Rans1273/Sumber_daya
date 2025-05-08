<?php
    
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiPerkebunanTable extends Migration
{
    public function up()
    {
        Schema::create('produksi_perkebunan', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan');
            $table->integer('kelapa')->nullable();
            $table->integer('kopi')->nullable();
            $table->integer('kakao')->nullable();
            $table->integer('tebu')->nullable();
            $table->integer('tembakau')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produksi_perkebunan');
    }
}
