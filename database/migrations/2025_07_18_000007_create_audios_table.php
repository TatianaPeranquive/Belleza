<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('audios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('archivo');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('audios');
    }
};