<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            ['nombre' => 'María Fernanda Fitzgerald', 'oficio' => 'Periodista', 'locacion' => 'Bogotá', 'edad' => 0],
            ['nombre' => 'Diana Bonnett', 'oficio' => 'Historiadora', 'locacion' => 'Medellín', 'edad' => 0],
            ['nombre' => 'Carol Figeroa', 'oficio' => 'Periodista', 'locacion' => 'Bogotá', 'edad' => 0],
            ['nombre' => 'Paola Turbay', 'oficio' => 'Actriz', 'locacion' => 'Bogotá', 'edad' => 0],
            ['nombre' => 'Lucia Meneses', 'oficio' => 'Antropóloga', 'locacion' => '', 'edad' => 0],
            ['nombre' => 'Melissa Jiménez', 'oficio' => 'Geógrafa', 'locacion' => 'Cali', 'edad' => 0],
            ['nombre' => 'Natalie', 'oficio' => 'Chef', 'locacion' => 'Bogotá', 'edad' => 0],
            ['nombre' => 'Diana Suaza', 'oficio' => 'Antropóloga', 'locacion' => 'Bogotá', 'edad' => 0],
            ['nombre' => 'Himelda Estupiñán', 'oficio' => 'Vendedora Amway', 'locacion' => 'Duitama', 'edad' => 0],
            ['nombre' => 'Mariana', 'oficio' => 'Estudiante-blogger', 'locacion' => 'Bogotá', 'edad' => 0],
            ['nombre' => 'Angélica Blanco', 'oficio' => 'Historiadora', 'locacion' => 'Bogotá', 'edad' => 0],
            ['nombre' => 'Anggy Peranquive Gómez', 'oficio' => 'Ingeniera Electrónica', 'locacion' => 'Bogotá', 'edad' => 29]

        ]);
    }
}
