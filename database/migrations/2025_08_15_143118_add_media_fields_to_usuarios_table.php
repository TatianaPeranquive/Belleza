<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
                   // Agregar columnas si no existen
            if (!Schema::hasColumn('usuarios', 'color')) {
                $table->string('color', 9)->nullable()->after('locacion');
            }
            if (!Schema::hasColumn('usuarios', 'foto')) {
                $table->string('foto')->nullable()->after('color');
            }
            if (!Schema::hasColumn('usuarios', 'audio')) {
                $table->string('audio')->nullable()->after('foto');
                }
        });
            $driver = DB::getDriverName();


               DB::table('usuarios')->orderBy('id')->chunk(500, function ($rows) {
                $palette = ['#C3B1E1', '#FFD700', '#96D1C5', '#FED2AA'];
                foreach ($rows as $r) {
                    $foto  = preg_replace('/\s+/', '', $r->nombre).'_foto.png';
                    $audio = $r->id.'_audio.mp3';
                    $color = $palette[$r->id % 4];
                    DB::table('usuarios')->where('id', $r->id)->update(compact('foto','audio','color'));
                }
                 });
    }





    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            //
        });
    }
};
