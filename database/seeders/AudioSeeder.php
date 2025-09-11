<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AudioSeeder extends Seeder {
    public function run() {
        DB::table('audios')->insert([
            ['nombre'=>'Audio 1','archivo'=>'audio/audio1.mp3','descripcion'=>'Primer audio demo'],
            ['nombre'=>'Audio 2','archivo'=>'audio/audio2.mp3','descripcion'=>'Segundo audio demo']
        ]);
    }
}
