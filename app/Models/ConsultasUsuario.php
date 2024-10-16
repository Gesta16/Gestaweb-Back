<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultasUsuario extends Model
{
    use HasFactory;

    protected $table = 'consultas_usuario';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha',
        'nombre_consulta',
    ];

}
