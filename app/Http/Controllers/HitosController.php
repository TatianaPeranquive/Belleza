<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// app/Http/Controllers/HitosController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HitosController extends Controller
{
    public function index(Request $request)
    {
        $initial = $request->integer('hito');      // lee ?hito=1|2|3
        if (!in_array($initial, [1,2,3], true)) {
            $initial = null;
        }
        return view('hitos', compact('initial'));
    }
}

