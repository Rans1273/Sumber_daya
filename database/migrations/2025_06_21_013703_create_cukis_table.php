<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateCukisTable extends Migration {
    public function up() {
        Schema::create('cukis', function (Blueprint $table) {
            $table->id();
            $table->string('s')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('cukis');
    }
}