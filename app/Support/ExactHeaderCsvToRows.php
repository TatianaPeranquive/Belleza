<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;
use RuntimeException;

class ExactHeaderCsvToRows
{
    public static function build(string $csvPath, string $table, array $opts = []): array
    {
        $ctx = self::makeContext($csvPath, $table, $opts);

        [$dbCols, $dbColsLower] = self::getDbColumns($ctx['table'], $ctx['connection']);
        $fh = self::openFile($ctx['csvPath']);

        try {
            [$header, $ctx] = self::parseHeader($fh, $ctx);
            $map = self::createHeaderMap($header, $dbColsLower, $ctx['table'], $ctx['policy']);
            $rows = iterator_to_array(self::rowsGenerator($fh, $map, $ctx), false);
            return self::finalizeRows($rows, $dbCols, $ctx['add_timestamps']);
        } finally {
            fclose($fh);
        }
    }

    private static function makeContext(string $csvPath, string $table, array $opts): array
    {
        if (!is_file($csvPath)) {
            throw new RuntimeException("CSV no encontrado: {$csvPath}");
        }
        return [
            'csvPath'        => $csvPath,
            'table'          => $table,
            'delimiter'      => $opts['delimiter']     ?? null,
            'enclosure'      => $opts['enclosure']     ?? '"',
            'escape'         => $opts['escape']        ?? '\\',
            'policy'         => $opts['policy']        ?? 'strict',
            'null_values'    => $opts['null_values']   ?? ['', 'NULL', 'null'],
            'add_timestamps' => (bool)($opts['add_timestamps'] ?? true),
            'connection'     => $opts['connection']    ?? null,
            'delimiter_pool' => $opts['delimiter_pool'] ?? [',', ';', "\t", '|'],
            'value_normalizer' => $opts['value_normalizer'] ?? null,
        ];
    }

    private static function openFile(string $path)
    {
        $fh = fopen($path, 'r');
        if ($fh === false) {
            throw new RuntimeException("No se pudo abrir el CSV: {$path}");
        }
        return $fh;
    }

    private static function readRawHeaderLine($fh): string
    {
        $line = fgets($fh);
        if ($line === false) {
            throw new RuntimeException("El CSV no tiene encabezado.");
        }
        if (strncmp($line, "\xEF\xBB\xBF", 3) === 0) {
            $line = substr($line, 3);
        }
        return rtrim($line, "\r\n");
    }

    private static function detectDelimiterFromHeaderLine(string $line, array $candidates): string
    {
        $best = $candidates[0] ?? ',';
        $bestScore = substr_count($line, $best);
        foreach ($candidates as $cand) {
            $score = substr_count($line, $cand);
            if ($score > $bestScore) {
                $best = $cand;
                $bestScore = $score;
            }
        }
        return $best;
    }

    private static function parseHeaderLine(string $line, string $delimiter, string $enclosure, string $escape): array
    {
        $header = str_getcsv($line, $delimiter, $enclosure, $escape);
        $header = array_map('trim', $header);
        if (count($header) === 0) {
            throw new RuntimeException("Encabezado vacío tras parseo.");
        }
        return $header;
    }

    private static function parseHeader($fh, array $ctx): array
    {
        $raw = self::readRawHeaderLine($fh);
        $delimiter = $ctx['delimiter'] ?? self::detectDelimiterFromHeaderLine($raw, $ctx['delimiter_pool']);
        $header = self::parseHeaderLine($raw, $delimiter, $ctx['enclosure'], $ctx['escape']);
        $ctx['delimiter'] = $delimiter;
        return [$header, $ctx];
    }

    private static function getDbColumns(string $table, ?string $connection): array
    {
        $dbCols = Schema::connection($connection)->getColumnListing($table);
        $dbColsLower = [];
        foreach ($dbCols as $c) {
            $dbColsLower[strtolower($c)] = $c;
        }
        return [$dbCols, $dbColsLower];
    }

    private static function createHeaderMap(array $header, array $dbColsLower, string $table, string $policy): array
    {
        $map = [];
        foreach ($header as $h) {
            $key = strtolower($h);
            if (array_key_exists($key, $dbColsLower)) {
                $map[] = $dbColsLower[$key];
            } else {
                if ($policy === 'strict') {
                    throw new RuntimeException("Columna del CSV no existe en la tabla '{$table}': {$h}");
                }
                $map[] = null;
            }
        }
        if ($policy === 'intersect' && count(array_filter($map, fn($c) => $c !== null)) === 0) {
            throw new RuntimeException("Ninguna columna del CSV coincide con '{$table}' (policy=intersect).");
        }
        return $map;
    }

    private static function rowsGenerator($fh, array $map, array $ctx): \Generator
    {
        $totalCols = count($map);
        while (($data = fgetcsv($fh, 0, $ctx['delimiter'], $ctx['enclosure'], $ctx['escape'])) !== false) {
            $data = self::alignDataLength($data, $totalCols);
            $assoc = self::rowAssocFromData($data, $map, $ctx['null_values'], $ctx['value_normalizer']);
            if (!empty($assoc)) {
                yield $assoc;
            }
        }
    }

    private static function alignDataLength(array $data, int $totalCols): array
    {
        $count = count($data);
        if ($count < $totalCols) {
            return array_pad($data, $totalCols, null);
        }
        if ($count > $totalCols) {
            return array_slice($data, 0, $totalCols);
        }
        return $data;
    }

    private static function rowAssocFromData(array $data, array $map, array $nullValues, $normalizer = null): array
    {
        $assoc = [];
        foreach ($map as $i => $col) {
            if ($col === null) continue;
            $assoc[$col] = self::cleanValue($data[$i] ?? null, $nullValues, $normalizer);
        }
        return $assoc;
    }


    private static function cleanValue($val, array $nullValues, $normalizer = null)
    {
        if (in_array($val, $nullValues, true)) return null;
        if (is_string($val)) {
            $val = trim($val);
            if ($normalizer) {
                $val = $normalizer($val);
            }
        }
        return $val;
    }


    private static function finalizeRows(array $rows, array $dbCols, bool $addTimestamps): array
    {
        if (!$addTimestamps) return $rows;

        $hasCreated = in_array('created_at', $dbCols, true);
        $hasUpdated = in_array('updated_at', $dbCols, true);
        if (!$hasCreated && !$hasUpdated) return $rows;

        $now = now();
        foreach ($rows as &$r) {
            if ($hasCreated && !array_key_exists('created_at', $r)) $r['created_at'] = $now;
            if ($hasUpdated && !array_key_exists('updated_at', $r)) $r['updated_at'] = $now;
        }
        unset($r);
        return $rows;
    }
}
