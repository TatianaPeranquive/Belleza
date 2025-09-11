<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CuraduriaFiltro extends Model {
    protected $fillable=[
        'comentario',
        'nombre_usuario',
        'categoria_id'
    ];
}
