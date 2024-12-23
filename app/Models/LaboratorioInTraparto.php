<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratorioInTraparto extends Model
{
    use HasFactory;

    protected $table = 'laboratorios_intraparto_gestante';

    protected $primaryKey = 'cod_intraparto';

    public $timestamps = false;

    protected $fillable = [
        'cod_intraparto',
        'id_usuario',
        'id_operador',
        'cod_vdrl',
        'pru_sifilis',
        'fec_sifilis',
        'fec_vdrl',
        'rec_sifilis',
        'fec_tratamiento',
        'pru_vih',
        'fec_vih',
        'proceso_gestativo_id',
        'reali_prueb_trepo_rapi_sifilis_intra',
        'reali_prueb_no_trepo_vdrl_sifilis_intra',
        'reali_prueb_rapi_vih'
    ];

    
    public function pruebaVdrl()
    {
        return $this->belongsTo(PruebaNoTreponemicaVDRL::class, 'cod_vdrl');
    }
}
