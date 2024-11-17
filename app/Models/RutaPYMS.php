<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutaPYMS extends Model
{
    use HasFactory;

    protected $table = '_ruta__p_y_m_s';

    protected $primaryKey = 'cod_ruta';

    public $timestamps = false;

    protected $fillable = [
        'cod_ruta',
        'id_usuario',
        'id_operador',
        'fec_bcg',
        'fec_hepatitis',
        'fec_seguimiento',
        'fec_entrega',
        'proceso_gestativo_id',
        'aplico_vacuna_bcg',
        'aplico_vacuna_hepatitis',
        'reali_entrega_carnet',
    ];
}
