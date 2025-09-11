<?php
namespace App\Http\Controllers;
use App\Models\Audios;
class AudioController extends Controller {
    public function index(){
        return Audios::all();
    }
}

