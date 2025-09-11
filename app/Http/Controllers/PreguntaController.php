<?php
namespace App\Http\Controllers;
use App\Models\Pregunta;
class PreguntaController extends Controller {
    public function index(){
        return Pregunta::all();
    }
}
