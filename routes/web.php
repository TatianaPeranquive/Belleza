<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EntrevistaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CuraduriaFiltroController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\DiccionarioController;
use App\Http\Controllers\HitosController;
use App\Http\Controllers\ResumenFiltroApiController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/theme/{theme}', function (string $theme) {
    $theme = in_array($theme, ['light','dark']) ? $theme : 'light';
    session(['theme' => $theme]);
    return back();
})->name('theme.switch');

Route::prefix('api/resumen')->group(function () {
    Route::get('/hitos',                  [ResumenFiltroApiController::class, 'hitos']);         // categoria_1
    Route::get('/sub1',                   [ResumenFiltroApiController::class, 'sub1']);          // requiere ?hito=
    Route::get('/sub2',                   [ResumenFiltroApiController::class, 'sub2']);          // requiere ?hito=&sub1=
    Route::get('/sub3',                   [ResumenFiltroApiController::class, 'sub3']);          // requiere ?hito=&sub1=&sub2=
    Route::get('/buscar',                 [ResumenFiltroApiController::class, 'buscar']);        // trae filas filtradas por lo elegido
    Route::get('/buscar-texto',           [ResumenFiltroApiController::class, 'buscarTexto']);   // full-text en comentario (opcional)
});

Route::get('/hitos', [HitosController::class, 'index'])->name('hitos.index');

Route::controller(DiccionarioController::class)
    ->prefix('diccionario')
    ->group(function () {
        Route::get('/', 'index')->name('diccionario.index');
        Route::get('/buscar', 'show');  // si usas ?palabra= en query
        Route::get('/{palabra}', 'buscar')->name('diccionario.buscar');
    });

    Route::prefix('entrevistas')->group(function () {
Route::prefix('detras-del-espejo')->group(function() {
    Route::get('/', [EntrevistaController::class, 'detrasShowMany'])
    ->name('detras.many');
    Route::get('/{id}', [EntrevistaController::class, 'detrasShow'])
    ->whereNumber('id')
    ->name('detras.show');
});
});

  //  Route::get('/about', function () {return view('usuarios');})->name('usuarios');

Route::prefix('entrevistas')->group(function () {
    Route::get('/', [EntrevistaController::class, 'index'])->name('entrevistas.index');

    // 1) Rutas específicas primero
    Route::get('/importar-entrevistas', [EntrevistaController::class, 'create'])
        ->name('entrevistas.import.create');
    Route::post('/importar-entrevistas', [EntrevistaController::class, 'store'])
        ->name('entrevistas.import.store');

    // 2) La "catch-all" SIEMPRE al final
    Route::get('/{slug}', [EntrevistaController::class, 'show'])
        ->name('entrevistas.show');
});

Route::get('/espejo/paint', function () {
    return view('paint'); // resources/views/paint.blade.php
})->name('espejo.paint');

Route::prefix('usuarios')->group(function() {
    Route::get('/',
    [UsuarioController::class,
    'index'])->name('usuarios.index');
});

Route::prefix('categorias')->group(function() {
    Route::get('/',
    [CategoriaController::class,
    'index'])->name('categorias.index');
});

Route::prefix('curaduria')->group(function() {
    Route::get('/',
    [CuraduriaFiltroController::class,
    'index'])->name('curaduria.index');
});

Route::prefix('audios')->group(function() {
    Route::get('/',
    [AudioController::class,
    'index'])->name('audio.index');
});

