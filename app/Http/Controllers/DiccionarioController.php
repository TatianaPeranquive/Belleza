<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diccionario;
use Illuminate\Support\Facades\Http;

class DiccionarioController extends Controller
{

public function buscar($palabra)
{
    $url = "https://es.wiktionary.org/w/api.php";

    $response = Http::withHeaders([
        'User-Agent' => 'MiEspejoApp/1.0 (https://tusitio.com; contacto@tucorreo.com)'
    ])->get($url, [
        'action'      => 'query',
        'prop'        => 'extracts',
        'titles'      => $palabra,
        'format'      => 'json',
        'explaintext' => 1,
    ]);

    if ($response->successful()) {
        $data = $response->json();
        $pages = $data['query']['pages'] ?? [];

        $page = array_values($pages)[0] ?? null;
        $extract = $page['extract'] ?? null;

        return view('diccionario.show', [
            'palabra'    => $palabra,
            'definicion' => $extract,
            'ejemplo'    => null,
        ]);
    }

    return view('diccionario.show', [
        'palabra'    => $palabra,
        'definicion' => null,
        'ejemplo'    => null,
    ]);
}


public function show(Request $request)
{
    $palabra = trim((string) $request->query('palabra', ''));
    if ($palabra === '') {
        return response()->json(['found' => false, 'msg' => 'Palabra vacía'], 400);
    }

    // Búsqueda case-insensitive
    $row = Diccionario::whereRaw('LOWER(palabra) = LOWER(?)', [$palabra])->first();

    if (!$row) {
        return response()->json(['found' => false, 'palabra' => $palabra]);
    }

    return response()->json([
        'found'      => true,
        'palabra'    => $row->palabra,
        'definicion' => $row->definicion,
    ]);
}


// public function buscar($palabra)
// {
//     $url = "https://es.wiktionary.org/w/api.php";
//     $response = Http::get($url, [
//         'action'      => 'query',
//         'prop'        => 'extracts',
//         'titles'      => $palabra,
//         'format'      => 'json',
//         'explaintext' => 1,
//     ]);

//     // 👇 Aquí mostramos crudo lo que devuelve la API
//     dd([
//         'status' => $response->status(),
//         'body'   => $response->body(),
//         'json'   => $response->json(),
//     ]);
// }


}
