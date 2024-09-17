<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlPrenatal extends Model
{
    // Tabla asociada
    protected $table = 'control_prenatal';

    // Clave primaria personalizada
    protected $primaryKey = 'cod_control';

    // No queremos usar los timestamps por defecto (created_at, updated_at)
    public $timestamps = false;

    // Los atributos que son asignables en masa
    protected $fillable = [
        'cod_control',
        'id_operador',
        'id_usuario',
        'cod_fracaso',
        'edad_gestacional',
        'trim_ingreso',
        'fec_mestruacion',
        'fec_parto',
        'emb_planeado',
        'fec_anticonceptivo',
        'fec_consulta',
        'fec_control',
        'ries_reproductivo',
        'fac_asesoria',
        'usu_solicito',
        'fec_terminacion',
        'per_intergenesico'
    ];

    // Relaciones con otras tablas
    public function operador()
    {
        return $this->belongsTo(Operador::class, 'id_operador', 'id_operador');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function metodoFracaso()
    {
        return $this->belongsTo(MetodoFracaso::class, 'cod_fracaso', 'cod_fracaso');
    }
}
