<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudioHipotiroidismoCongenito extends Model
{
    use HasFactory;

    protected $table = 'estudio_hipotiroidismo_congenito';

    protected $primaryKey = 'cod_estudio';

    public $timestamps = false;

    protected $fillable = [
        'cod_estudio',
        'id_usuario',
        'id_operador',
        'tsh',
        'fec_resultado',
        't4_libre',
        'fec_resultadot4',
        'eve_confirmado',
        'fec_primera',
        'proceso_gestativo_id'
    ];

}
