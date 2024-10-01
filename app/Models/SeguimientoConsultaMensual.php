<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoConsultaMensual extends Model
{
    use HasFactory;

    protected $table = 'seguimiento_consulta_mensual'; 

    protected $primaryKey = 'cod_seguimiento'; 

    public $timestamps = false;

    protected $fillable = [
        'cod_seguimiento',
        'id_usuario',
        'id_operador',
        'cod_riesgo',
        'cod_controles',
        'cod_diagnostico',
        'cod_medicion',
        'fec_consulta',
        'edad_gestacional',
        'alt_uterina',
        'trim_gestacional',
        'peso',
        'talla',
        'imc',
        'ten_arts',
        'ten_artd',
    ];

    
    public function riesgo()
    {
        return $this->belongsTo(Riesgo::class, 'cod_riesgo');
    }

    public function controles()
    {
        return $this->belongsTo(NumeroControl::class, 'cod_controles');
    }

    public function diagnostico()
    {
        return $this->belongsTo(DiagnosticoNutricional::class, 'cod_diagnostico');
    }

    public function medicion()
    {
        return $this->belongsTo(FormaMedicion::class, 'cod_medicion');
    }
}
