<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimeraConsulta extends Model
{
    protected $table = 'primera_consulta';
    protected $primaryKey = 'cod_consulta';
    public $timestamps = false;

    protected $fillable = [
        'id_operador',
        'id_usuario',
        'cod_riesgo',
        'cod_dm',
        'peso_previo',
        'tal_consulta',
        'imc_consulta',
        'diag_nutricional',
        'hta',
        'dm',
        'fact_riesgo',
        'expo_violencia',
        'ries_depresion',
        'for_gestacion',
        'for_parto',
        'for_cesarea',
        'for_aborto',
        'fec_lactancia',
        'fec_consejeria',
        'proceso_gestativo_id'
    ];

    public function operador()
    {
        return $this->belongsTo(Operador::class, 'id_operador');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function riesgo()
    {
        return $this->belongsTo(Riesgo::class, 'cod_riesgo');
    }

    public function tipoDm()
    {
        return $this->belongsTo(TipoDm::class, 'cod_dm');
    }
}
