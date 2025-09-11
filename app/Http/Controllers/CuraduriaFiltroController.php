<?php
namespace App\Http\Controllers;
use App\Models\CuraduriaFiltro;
class CuraduriaFiltroController extends Controller {
    public function index(){
        return CuraduriaFiltro::all();
    }
}
