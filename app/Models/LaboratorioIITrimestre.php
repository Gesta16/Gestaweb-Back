<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratorioIITrimestre extends Model
{
    use HasFactory;

    protected $table = 'laboratorio_ii_trimestre';
    protected $primaryKey = 'cod_doslaboratorio';

    public $timestamps = false;


    protected $fillable = [
        'id_operador',
        'id_usuario',
        'pru_vih',
        'fec_vih',
        'pru_sifilis',
        'fec_sifilis',
        'pru_oral',
        'pru_uno',
        'pru_dos',
        'fec_prueba',
        'rep_citologia',
        'fec_citologia',
        'ig_toxoplasma',
        'fec_toxoplasma',
        'pru_avidez',
        'fec_avidez',
        'tox_laboratorio',
        'fec_toxoplasmosis',
        'hem_gruesa',
        'fec_hemoparasito',
        'coo_cualitativo',
        'fec_coombs',
        'fec_ecografia',
        'eda_gestacional',
        'rie_biopsicosocial',
        'proceso_gestativo_id',
        'reali_prueb_rapi_vih',
        'real_prueb_trep_rap_sifilis',
        'reali_citologia',
        'reali_prueb_avidez_ig_g',
        'reali_prueb_toxoplasmosis_ig_a',
        'reali_prueb_hemoparasito',
        'reali_prueb_coombis_indi_cuanti',
        'reali_eco_obste_detalle_anato'
        
    ];

    public function operador()
    {
        return $this->belongsTo(Operador::class, 'id_operador', 'id_operador');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
