<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EntrevistaController extends Controller
{

    public function index()
    {
        $rows = DB::table('entrevistas as e')
            ->join('usuarios as u', 'u.id', '=', 'e.usuario_id')
            ->select('u.id', 'u.nombre', 'u.color')
            ->groupBy('u.id', 'u.nombre', 'u.color')
            ->orderBy('u.nombre')
            ->get();

        // Paleta según tema activo
        $theme    = session('theme', config('theme.active'));
        $palette  = config("theme.palettes.$theme.card_bg");

        $cards = $rows->map(function ($r) use ($palette) {
            return [
                'slug'  => Str::slug($r->nombre, '_'),
                'name'  => $r->nombre,
                'color' => $r->color ?: $palette[$r->id % count($palette)],
            ];
        })->values()->all();
        return view('entrevistas.index', compact('cards'));
    }

    public function show($slug)
    {
        // Buscar por slug calculado desde el nombre (sin columna slug en BD)
        $rows = DB::table('entrevistas as e')
            ->join('usuarios as u', 'u.id', '=', 'e.usuario_id')
            ->join('respuestas as r', 'e.id', '=', 'r.entrevista_id')
            ->select('u.nombre', 'u.color', 'u.foto', 'u.audio', 'u.edad', 'u.oficio', 'u.locacion', 'r.valor')
            ->groupBy('u.nombre', 'u.color', 'u.foto', 'u.audio', 'u.edad', 'u.oficio', 'u.locacion', 'r.valor')
            ->get();

        $row = $rows->first(fn($r) => Str::slug($r->nombre, '_') === $slug);
        if (!$row) abort(404);

        $entrevistada = [
            'nombre'   => $row->nombre,
            'foto'     => $row->foto,
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
            ->first([
                'id',
                'nombre',
                'color',
                'foto',
                'audio',
                'edad',
                'oficio',
                'locacion',
            ]);

        if (!$u) abort(404);

        // Por si en BD faltara foto/audio
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
            'volverRoute' => 'home', //editable
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

        if (empty($ids)) {
            abort(404);
        }

        $rows = DB::table('usuarios')
            ->whereIn('id', $ids)
            ->get(['id', 'nombre', 'color', 'foto', 'audio', 'edad', 'oficio', 'locacion']);

        if ($rows->isEmpty()) {
            abort(404);
        }

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
