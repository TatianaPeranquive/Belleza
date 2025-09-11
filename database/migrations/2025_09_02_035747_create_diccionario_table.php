<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('diccionario', function (Blueprint $table) {
        $table->id();
        $table->string('palabra')->unique();
        $table->text('definicion');
        $table->text('ejemplo')->nullable();
        $table->string('imagen')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diccionario');
    }
};
