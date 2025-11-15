<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EntrevistaController extends Controller
{
    /* ===========================
     *  VISTA DE IMPORTACIÓN
     * =========================== */
    public function create()
    {
        // Blade simple con <input name="table"> y <input type="file" name="file">
        // Ej: resources/views/entrevistas/import.blade.php
        return view('entrevistas.import');
    }

    /* ===========================
     *  PROCESAR IMPORTACIÓN
     * =========================== */

    public function store(Request $request)
    {
        $request->validate([
            'table' => ['required','string'],
            'file'  => ['required','file','mimes:csv,txt'], // <- solo csv/txt
        ]);

        $table = $request->string('table')->trim()->toString();
        if (!Schema::hasTable($table)) {
            return back()->withErrors(['table' => "La tabla '{$table}' no existe."]);
        }

        $path = $request->file('file')->getRealPath();
        if (!file_exists($path)) {
            return back()->withErrors(['file' => 'No se pudo abrir el archivo.']);
        }

        [$headers, $rows] = $this->readCsvWithHeaders($path);
        if (empty($headers)) {
            return back()->withErrors(['file' => 'El CSV no tiene encabezados válidos.']);
        }

        $tableCols = Schema::getColumnListing($table);
        $usable = array_values(array_intersect($headers, $tableCols));
        if (empty($usable)) {
            return back()->withErrors(['file' =>
                'Ninguna columna del archivo coincide con la tabla. '.
                'Encabezados: ['.implode(', ', $headers).']; Tabla: ['.implode(', ', $tableCols).']'
            ]);
        }

        $batch = []; $inserted = 0; $batchSize = 1000;
        DB::beginTransaction();
        try {
            foreach ($rows as $r) {
                $row = [];
                foreach ($usable as $col) {
                    $row[$col] = $this->normalize($r[$col] ?? null);
                }
                if (count(array_filter($row, fn($v)=>!is_null($v))) === 0) continue;

                if (in_array('created_at', $tableCols) && !array_key_exists('created_at', $row)) $row['created_at'] = now();
                if (in_array('updated_at', $tableCols) && !array_key_exists('updated_at', $row)) $row['updated_at'] = now();

                $batch[] = $row;
                if (count($batch) >= $batchSize) { DB::table($table)->insert($batch); $inserted += count($batch); $batch=[]; }
            }
            if ($batch) { DB::table($table)->insert($batch); $inserted += count($batch); }

            DB::commit();
            return back()->with('ok', "Importación completada en '{$table}'. Filas insertadas: {$inserted}");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['file' => 'Error: '.$e->getMessage()]);
        }
    }

    private function readCsvWithHeaders(string $path): array
    {
        $delimiter = $this->detectDelimiter($path);
        $h = fopen($path, 'r'); if (!$h) return [[],[]];
        $headers = []; $rows = []; $line = 0;

        while (($row = fgetcsv($h, 0, $delimiter)) !== false) {
            $line++;
            if ($line === 1) {
                if (isset($row[0])) $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
                $headers = array_map(fn($c)=>trim((string)$c), $row);
                continue;
            }
            $assoc = [];
            foreach ($headers as $i => $hname) {
                if ($hname === '') continue;
                $assoc[$hname] = $row[$i] ?? null;
            }
            $rows[] = $assoc;
        }
        fclose($h);
        return [$headers, $rows];
    }

    private function detectDelimiter(string $path): string
    {
        $line = ''; $h = fopen($path, 'r'); if ($h) { $line = fgets($h, 8192) ?: ''; fclose($h); }
        $c = [","=>0,";"=>0,"|"=>0,"\t"=>0]; foreach ($c as $d=>$_) $c[$d] = substr_count($line, $d);
        arsort($c); $best = array_key_first($c); return ($c[$best] > 0) ? $best : ',';
    }

    private function normalize($v)
    {
        if ($v === null) return null;
        if (is_string($v)) {
            $v = trim($v);
            if ($v === '' || strtoupper($v) === 'NULL') return null;
            $l = strtolower($v); if ($l==='true') return true; if ($l==='false') return false;
            if (is_numeric($v)) return (strpos($v,'.')!==false) ? (float)$v : (int)$v;
        }
        return $v;
    }



    /* ======================================
     *  OTRAS ACCIONES (index/show/etc.)
     * ====================================== */

    public function index()
        {
            $rows = DB::table('entrevistas as e')
                ->join('usuarios as u', 'u.id', '=', 'e.usuario_id')
                ->select('u.id', 'u.nombre', 'u.color')
                ->groupBy('u.id', 'u.nombre', 'u.color')
                ->orderBy('u.nombre')
                ->get();

            $total = $rows->count();

            // Paleta fija por "columna"
            $columnPalette = [
                '#D4F2D2', // verde suave
                '#BEB7DF', // lila
                '#ABA9BF', // gris-lila
            ];

            $mod = $total % 3;

            $cards = $rows->values()->map(function ($r, $index) use ($total, $columnPalette, $mod) {

                // ¿es la última y queda solita (total ≡ 1 mod 3)?
                $forceMiddle = ($index === $total - 1) && ($mod === 1);

                // columna lógica
                $colIndex = $forceMiddle ? 1 : ($index % 3);

                $baseBg = $columnPalette[$colIndex];

                // criterio de “seleccionada” (ajusta si usas otro campo)
                $isSelected = !empty($r->color);

                $bgColor     = $isSelected ? '#34113F' : $baseBg;
                $textColor   = $isSelected ? '#F9FAFB' : '#111827';
                $borderColor = $isSelected ? '#BEB7DF' : '#ABA9BF';

                return [
                    'slug'     => Str::slug($r->nombre, '_'),
                    'name'     => $r->nombre,
                    'bg'       => $bgColor,
                    'text'     => $textColor,
                    'border'   => $borderColor,
                    'colStart' => $forceMiddle ? 'lg:col-start-2' : '',
                ];
            })->all();

            return view('entrevistas.index', ['cards' => $cards]);
        }
        public function limpiarHtml($texto) {
            return preg_replace(
                '/<script\b[^>]*>(.*?)<\/script>/is',
                '',
                strip_tags($texto, '<p><strong><em><b><i><u><br>')
            );
        }

    public function show($slug)
    {
        $rows = DB::table('entrevistas as e')
            ->join('usuarios as u', 'u.id', '=', 'e.usuario_id')
            ->join('respuestas as r', 'e.id', '=', 'r.entrevista_id')
            ->select('u.nombre', 'u.color', 'u.foto', 'u.audio', 'u.edad', 'u.oficio', 'u.locacion', 'r.valor')
            ->groupBy('u.nombre', 'u.color', 'u.foto', 'u.audio', 'u.edad', 'u.oficio', 'u.locacion', 'r.valor')
            ->get();

        $row = $rows->first(fn($r) => Str::slug($r->nombre, '_') === $slug);
        if (!$row) abort(404);

        $foto  = $row->foto  ?: (preg_replace('/\s+/', '', $row->nombre) . '_foto.png');
        //$audio = $row->audio ?: ($row->id . '_audio.mp3');

        $entrevistada = [
            'nombre'   => $row->nombre,
            'foto'     => !empty($row->foto)| isset($row->foto) ? $row->foto : $foto,
            'audio'    => $row->audio,
            'color'    => $row->color,
            'edad'     => $row->edad,
            'oficio'   => $row->oficio,
            'locacion' => $row->locacion,
            'perfil'   => $this->armarPerfil($row->nombre, $row->edad, $row->oficio, $row->locacion),
            'respuesta' => $row->valor,
        ];

        return view('entrevistas.show', $entrevistada);
    }

    private function armarPerfil(?string $nombre, ?int $edad, ?string $oficio, ?string $locacion): string
    {
        $partes = [];
        if ($nombre)   $partes[] = $nombre;
        if ($edad)     $partes[] = "{$edad} años";
        if ($oficio)   $partes[] = $oficio;
        if ($locacion) $partes[] = "({$locacion})";
        return implode(', ', array_filter($partes));
    }

    public function detrasShow(int $id)
    {
        $u = DB::table('usuarios')
            ->where('id', $id)
            ->first(['id','nombre','color','foto','audio','edad','oficio','locacion']);

        if (!$u) abort(404);

        $foto  = $u->foto  ?: (preg_replace('/\s+/', '', $u->nombre) . '_foto.png');
        $audio = $u->audio ?: ($u->id . '_audio.mp3');

        $data = [
            'nombre'   => $u->nombre,
            'foto'     => $foto,
            'audio'    => $audio,
            'color'    => $u->color,
            'edad'     => $u->edad,
            'oficio'   => $u->oficio,
            'locacion' => $u->locacion,
            'perfil'   => $this->armarPerfil($u->nombre, $u->edad, $u->oficio, $u->locacion),
            'volverRoute' => 'home',
        ];

        return view('entrevistas.show', $data);
    }

    public function detrasShowMany(Request $request)
    {
        $idsParam = $request->query('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn($x) => (int)trim($x))
            ->filter(fn($x) => $x > 0)
            ->unique()
            ->values()
            ->all();

        if (empty($ids)) abort(404);

        $rows = DB::table('usuarios')
            ->whereIn('id', $ids)
            ->get(['id','nombre','color','foto','audio','edad','oficio','locacion']);

        if ($rows->isEmpty()) abort(404);

        $autoras = $rows->map(function ($u) {
            $foto  = $u->foto ?: (preg_replace('/\s+/', '', $u->nombre) . '_foto.png');
            $audio = $u->audio ?: ($u->id . '_audio.mp3');
            return [
                'nombre'   => $u->nombre,
                'foto'     => $foto,
                'audio'    => $audio,
                'color'    => $u->color,
                'edad'     => $u->edad,
                'oficio'   => $u->oficio,
                'locacion' => $u->locacion,
                'perfil'   => $this->armarPerfil($u->nombre, $u->edad, $u->oficio, $u->locacion),
            ];
        })->values()->all();

        return view('entrevistas.show', [
            'autoras'      => $autoras,
            'volverRoute'  => 'home',
            'tituloPagina' => 'A cerca de nostros',
        ]);
    }
}
