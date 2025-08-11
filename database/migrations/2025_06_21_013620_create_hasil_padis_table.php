<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateHasilPadisTable extends Migration {
    public function up() {
        Schema::create('hasil_padis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_padi')->nullable();
            $table->string('cuki_padi')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('hasil_padis');
    }
}