<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    protected $fillable = [
        'nombreindicador',
        'codigoindicador',
        'unidadmedidaindicador',
        'valorindicador',
        'fechaindicador',
        'tiempoindicador',
        'origenindicador'
    ];
}
