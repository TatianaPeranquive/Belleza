<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Entrevista extends Model {
    protected $fillable=[
        'usuario_id',
        'pregunta_id',
        'respuesta_id',
        'fecha',
        'notas'
    ];
}
