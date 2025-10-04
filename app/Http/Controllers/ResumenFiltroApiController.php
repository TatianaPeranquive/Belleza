<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumenFiltroApiController extends Controller
{
    private string $table = 'resumen_centralizado';

    /* ===================== Helpers ===================== */

    /**
     * Lista de valores distintos (orden alfabético) para una columna,
     * opcionalmente filtrada por condiciones previas (contexto).
     */
    private function distinctValues(string $column, array $where = [])
    {
        $q = DB::table($this->table)
            ->select($column)
            ->whereNotNull($column);

        foreach ($where as $k => $v) {
            $q->where($k, $v);
        }

        return $q->distinct()->orderBy($column)->pluck($column)->values(); // Collection indexada 0..n-1
    }

    /**
     * Resuelve el valor real de un parámetro que puede venir como texto o como ID numérico (1..N).
     * Si es numérico, selecciona el N-ésimo (1-based) de la lista de distintos para esa columna y contexto.
     */
    private function resolveValue(string $column, $input, array $where = [])
    {
        if ($input === null || $input === '') {
            return null;
        }

        // Si viene como número -> mapear por índice (1..N) dentro del contexto dado
        if (is_numeric($input)) {
            $idx = (int) $input;
            $list = $this->distinctValues($column, $where);
            return ($idx >= 1 && $idx <= $list->count()) ? $list[$idx - 1] : null;
        }

        // Si viene como texto -> úsalo tal cual
        return $input;
    }

    /**
     * Mapea una colección de strings a objetos { id, title, value } con id 1..N.
     */
    private function mapListToItems($values)
    {
        return $values->values()->map(function ($v, $i) {
            return [
                'id'    => $i + 1,   // 1-based para el frontend
                'title' => $v,
                'value' => $v,
            ];
        })->all();
    }

    /* ===================== Endpoints ===================== */

    // Nivel 0
    public function hitos()
    {
        $vals = $this->distinctValues('categoria_1');
        return response()->json($this->mapListToItems($vals));
    }

    // Nivel 1 (requiere hito como string o id)
    public function sub1(Request $req)
    {
        $hitoIn = $req->query('hito');
        $hito   = $this->resolveValue('categoria_1', $hitoIn);

        if (!$hito) {
            return response()->json([]);
        }

        $vals = $this->distinctValues('categoria_2', ['categoria_1' => $hito]);
        return response()->json($this->mapListToItems($vals));
    }

    // Nivel 2 (requiere hito y sub1 como string o id)
    public function sub2(Request $req)
    {
        $hitoIn = $req->query('hito');
        $hito   = $this->resolveValue('categoria_1', $hitoIn);
        if (!$hito) return response()->json([]);

        $sub1In = $req->query('sub1');
        $sub1   = $this->resolveValue('categoria_2', $sub1In, ['categoria_1' => $hito]);
        if (!$sub1) return response()->json([]);

        $vals = $this->distinctValues('categoria_3', [
            'categoria_1' => $hito,
            'categoria_2' => $sub1,
        ]);

        return response()->json($this->mapListToItems($vals));
    }

    // Nivel 3 (requiere hito, sub1, sub2 como string o id)
    public function sub3(Request $req)
    {
        $hitoIn = $req->query('hito');
        $hito   = $this->resolveValue('categoria_1', $hitoIn);
        if (!$hito) return response()->json([]);

        $sub1In = $req->query('sub1');
        $sub1   = $this->resolveValue('categoria_2', $sub1In, ['categoria_1' => $hito]);
        if (!$sub1) return response()->json([]);

        $sub2In = $req->query('sub2');
        $sub2   = $this->resolveValue('categoria_3', $sub2In, ['categoria_1' => $hito, 'categoria_2' => $sub1]);
        if (!$sub2) return response()->json([]);

        $vals = $this->distinctValues('categoria_4', [
            'categoria_1' => $hito,
            'categoria_2' => $sub1,
            'categoria_3' => $sub2,
        ]);

        return response()->json($this->mapListToItems($vals));
    }

    // Filtrado final; acepta numérico o texto en hito/sub1/sub2/sub3
    public function buscar(Request $req)
    {
        // Resolver valores reales (texto) a partir de numérico si aplica
        $hito = $this->resolveValue('categoria_1', $req->query('hito'));
        $sub1 = $this->resolveValue('categoria_2', $req->query('sub1'), $hito ? ['categoria_1' => $hito] : []);
        $sub2 = $this->resolveValue('categoria_3', $req->query('sub2'), $hito && $sub1 ? ['categoria_1' => $hito, 'categoria_2' => $sub1] : []);
        $sub3 = $this->resolveValue('categoria_4', $req->query('sub3'), $hito && $sub1 && $sub2 ? ['categoria_1' => $hito, 'categoria_2' => $sub1, 'categoria_3' => $sub2] : []);

        $q = DB::table($this->table)->select('*');
        if ($hito) $q->where('categoria_1', $hito);
        if ($sub1) $q->where('categoria_2', $sub1);
        if ($sub2) $q->where('categoria_3', $sub2);
        if ($sub3) $q->where('categoria_4', $sub3);

        return $q->orderByDesc('categoria_1')->limit(200)->get();
    }

    // Full-text en comentario (opcional)
    public function buscarTexto(Request $req)
    {
        $texto = trim((string) $req->query('q', ''));
        if ($texto === '') return response()->json([]);

        return DB::table($this->table)
            ->whereRaw("comentario_tsv @@ plainto_tsquery('spanish', ?)", [$texto])
            ->limit(200)
            ->get();
    }
}
