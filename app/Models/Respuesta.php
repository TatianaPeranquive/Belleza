<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Respuesta extends Model {
    protected $fillable=
    ['usuario_id',
    'pregunta_id',
    'entrevista_id',
    'valor'
    ];
}
