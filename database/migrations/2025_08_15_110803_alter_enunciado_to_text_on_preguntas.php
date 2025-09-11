<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('preguntas', function (Blueprint $table) {
            $table->text('enunciado')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preguntas', function (Blueprint $table) {
            //TRUNCATE TABLE preguntas RESTART IDENTITY CASCADE;
            //ALTER SEQUENCE preguntas_id_seq RESTART WITH 1; //solo si esta vacia la tabla
            $table->string('enunciado', 255)->change();
        });
    }
};
