<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumenFiltroApiController extends Controller
{
    private string $table = 'resumen_centralizado';
    public function index(Request $request)
    {
    print('888888888888888888888888888888888888');
    }
    public function hitos()
    {

        $rows = DB::table($this->table)
            ->select('categoria_1')
            ->whereNotNull('categoria_1')
            ->distinct()
            ->pluck('categoria_1');
        return response()->json($rows);
    }

    public function sub1(Request $req)
    {
        $hito = $req->query('hito');

        if (!$hito) return response()->json([]);

        $rows = DB::table($this->table)
            ->select('categoria_2')
            ->where('categoria_1', $hito)
            ->whereNotNull('categoria_2')
            ->distinct()
            ->pluck('categoria_2');
//dd($rows->toSql(), $rows->getBindings());
        return response()->json($rows);
    }

    public function sub2(Request $req)
    {
        $hito = $req->query('hito');
        $sub1 = $req->query('sub1');
        if (!$hito || !$sub1) return response()->json([]);

        $rows = DB::table($this->table)
            ->select('categoria_3')
            ->where('categoria_1', $hito)
            ->where('categoria_2', $sub1)
            ->whereNotNull('categoria_3')
            ->distinct()
            ->pluck('categoria_3');

        return response()->json($rows);
    }

    public function sub3(Request $req)
    {
        $hito = $req->query('hito');
        $sub1 = $req->query('sub1');
        $sub2 = $req->query('sub2');
        if (!$hito || !$sub1 || !$sub2) return response()->json([]);

        $rows = DB::table($this->table)
            ->select('categoria_4')
            ->where('categoria_1', $hito)
            ->where('categoria_2', $sub1)
            ->where('categoria_3', $sub2)
            ->whereNotNull('categoria_4')
            ->distinct()
            ->pluck('categoria_4');

        return response()->json($rows);
    }

    // Trae filas filtradas por lo elegido (hasta donde llegue la cascada)
    public function buscar(Request $req)
    {
        $q = DB::table($this->table)->select('*');

        if ($req->filled('hito')) $q->where('categoria_1', $req->query('hito'));
        if ($req->filled('sub1')) $q->where('categoria_2', $req->query('sub1'));
        if ($req->filled('sub2')) $q->where('categoria_3', $req->query('sub2'));
        if ($req->filled('sub3')) $q->where('categoria_4', $req->query('sub3'));
        return $q->orderByDesc('categoria_1')->limit(200)->get();
    }

    // Full-text en comentario (opcional, requiere índice TSV)
    public function buscarTexto(Request $req)
    {
        $texto = trim((string)$req->query('q', ''));
        if ($texto === '') return response()->json([]);

        return DB::table($this->table)
            ->whereRaw("comentario_tsv @@ plainto_tsquery('spanish', ?)", [$texto])
            ->limit(200)
            ->get();
    }
}
