<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
class UsuarioController extends Controller {
    public function index(){return Usuario::all();
    }
}
