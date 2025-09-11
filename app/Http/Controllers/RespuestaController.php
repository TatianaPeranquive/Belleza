<?php
namespace App\Http\Controllers;
use App\Models\Respuesta;
class RespuestaController extends Controller {
    public function index(){return Respuesta::all();
    }
}
