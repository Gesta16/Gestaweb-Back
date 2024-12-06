<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoComplementario extends Model
{
    use HasFactory;

    protected $table = 'seguimientos_complementarios';

    protected $primaryKey = 'cod_segcomplementario';

    public $timestamps = false;


    protected $fillable = [
        'cod_segcomplementario',
        'id_usuario',
        'id_operador',
        'cod_sesiones',
        'fec_nutricion',
        'fec_ginecologia',
        'fec_psicologia',
        'fec_odontologia',
        'ina_seguimiento',
        'cau_inasistencia',
        'proceso_gestativo_id',
        'asistio_nutricionista',
        'asistio_ginecologia',
        'asistio_psicologia',
        'asistio_odontologia'
    ];

    
    public function sesiones()
    {
        return $this->belongsTo(NumSesionesCursoPaternidadMaternidad::class, 'cod_sesiones', 'cod_sesiones');
    }
}
