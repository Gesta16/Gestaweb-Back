<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosRecienNacido extends Model
{
    use HasFactory;

    protected $table = 'datos_recien_nacido';

    protected $primaryKey = 'cod_recien';

    public $timestamps = false;

    protected $fillable = [
        'cod_recien',
        'id_usuario',
        'id_operador',
        'tip_embarazo',
        'num_nacido',
        'sexo',
        'peso',
        'talla',
        'pla_canguro',
        'ips_canguro',
        'proceso_gestativo_id'
    ];
}
