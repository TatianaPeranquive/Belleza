<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsuarioSeeder extends Seeder {
    public function run() {
        DB::table('usuarios')->insert([
            ['nombre'=>'Tatiana','oficio'=>'Diseñadora','locacion'=>'Bogotá','edad'=>30],
            ['nombre'=>'Ana','oficio'=>'Ingeniera','locacion'=>'Medellín','edad'=>28],
           ['nombre' => 'María Fernanda', 'oficio' => 'Abogada', 'locacion' => 'Cali', 'edad' => 35]
        ]);
    }
}
