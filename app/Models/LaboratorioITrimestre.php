<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratorioITrimestre extends Model
{
    use HasFactory;

    protected $table = 'laboratorio_i_trimestre';
    
    protected $primaryKey = 'cod_laboratorio';

    public $timestamps = false;

    protected $fillable = [
        'id_operador', 'id_usuario', 'cod_hemoclasifi', 
        'cod_antibiograma', 'fec_hemoclasificacion', 'hem_laboratorio', 
        'fec_hemograma', 'gli_laboratorio', 'fec_glicemia', 'ant_laboratorio', 
        'fec_antigeno', 'pru_vih', 'fec_vih', 'pru_sifilis', 'fec_sifilis', 
        'uro_laboratorio', 'fec_urocultivo', 'fec_antibiograma', 'ig_rubeola', 
        'fec_rubeola', 'ig_toxoplasma', 'fec_toxoplasma', 'hem_gruesa', 
        'fec_hemoparasito', 'pru_antigenos', 'fec_antigenos', 'eli_recombinante', 
        'fec_recombinante', 'coo_cuantitativo', 'fec_coombs', 'fec_ecografia', 
        'eda_gestacional', 'rie_biopsicosocial'
    ];

    public function operador()
    {
        return $this->belongsTo(Operador::class, 'id_operador', 'id_operador');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function hemoclasificacion()
    {
        return $this->belongsTo(Hemoclasificacion::class, 'cod_hemoclasifi', 'cod_hemoclasifi');
    }

    public function antibiograma()
    {
        return $this->belongsTo(Antibiograma::class, 'cod_antibiograma', 'cod_antibiograma');
    }
}
