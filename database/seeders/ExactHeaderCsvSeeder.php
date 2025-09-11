<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Support\ExactHeaderCsvToRows;

abstract class ExactHeaderCsvSeeder extends Seeder
{
    protected string $table;
    protected ?string $csv = null;
    protected string $policy = 'strict';
    protected bool $addTimestamps = true;
    protected ?string $connection = null;
    protected array $builderOptions = [];

    public function run(): void
    {
        $csvPath = $this->csv ?? storage_path('app/import/' . $this->table . '.csv');

        if (!is_file($csvPath)) {
            $this->command?->warn("CSV no encontrado, se omite: {$csvPath}");
            return;
        }

        $rows = ExactHeaderCsvToRows::build($csvPath, $this->table, array_merge([
            'policy'         => $this->policy,
            'add_timestamps' => $this->addTimestamps,
            'connection'     => $this->connection,
        ], $this->builderOptions));

        if (empty($rows)) {
            $this->command?->warn("CSV vacío o sin filas válidas: {$csvPath}");
            return;
        }

        DB::connection($this->connection)->table($this->table)->insert($rows);
        $this->command?->info("Insertadas " . count($rows) . " filas en '{$this->table}'.");
    }
}
