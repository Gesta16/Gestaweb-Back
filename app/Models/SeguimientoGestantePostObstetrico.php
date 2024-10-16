<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoGestantePostObstetrico extends Model
{
    use HasFactory;

    protected $table = 'seguimiento_gestante_post_obstetrico'; 

    protected $primaryKey = 'cod_evento'; 
    
    public $timestamps = false;

    protected $fillable = [
        'cod_evento',
        'id_usuario',
        'id_operador',
        'cod_metodo',
        'con_egreso',
        'fec_fallecimiento',
        'fec_planificacion',
        'proceso_gest_id',
    ];

    
    public function metodo()
    {
        return $this->belongsTo(MetodoAnticonceptivo::class, 'cod_metodo', 'cod_metodo');
    }
}
