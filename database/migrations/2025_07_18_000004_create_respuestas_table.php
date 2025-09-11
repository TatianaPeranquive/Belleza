<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('pregunta_id')->constrained('preguntas')->onDelete('cascade');
            $table->foreignId('entrevista_id')->nullable()->constrained('entrevistas')->onDelete('cascade');
            $table->text('valor');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('respuestas');
    }
};
