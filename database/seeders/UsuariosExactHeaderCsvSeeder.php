<?php

namespace Database\Seeders;

class UsuariosExactHeaderCsvSeeder extends ExactHeaderCsvSeeder
{
    // Nombre de la tabla destino
    protected string $table = 'usuarios';

    // (Opcional) Forzar delimitador si tu CSV usa ; (típico Excel ES/LATAM)
    protected array $builderOptions = ['delimiter' => ';'];
    // protected array $builderOptions = [
    // 'delimiter' => ';',
    // 'value_normalizer' => fn($s) => mb_convert_encoding($s, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252'),
    // ];

    // (Opcional) Si NO vas a usar storage/app/import/usuarios.csv,
    // puedes especificar la ruta completa al CSV:
    // protected ?string $csv = 'C:/ruta/a/tu/archivo.csv';
}
