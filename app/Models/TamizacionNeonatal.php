<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TamizacionNeonatal extends Model
{
    use HasFactory;

    protected $table = 'tamizacion_neonatal';
    
    protected $primaryKey = 'cod_tamizacion';

    public $timestamps = false;

    protected $fillable = [
        'cod_tamizacion',
        'id_usuario',
        'id_operador',
        'cod_hemoclasifi',
        'fec_tsh',
        'resul_tsh',
        'fec_pruetrepo',
        'pruetreponemica',
        'tamiza_aud',
        'tamiza_cardi',
        'tamiza_visual',
        'proceso_gestativo_id',
        'reali_prueb_no_trepo_recien_nacido',
        'reali_tamiza_auditivo',
        'reali_tamiza_cardiopatia_conge',
        'reali_tamiza_visual'
    ];

    public function hemoclasificacion()
    {
        return $this->belongsTo(Hemoclasificacion::class, 'cod_hemoclasifi', 'cod_hemoclasifi');
    }
}
