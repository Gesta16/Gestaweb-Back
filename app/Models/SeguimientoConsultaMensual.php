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
        'id_operador',
        'id_usuario',
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
        'ten_artd'
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
