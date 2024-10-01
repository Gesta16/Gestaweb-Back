<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalizacionGestacion extends Model
{
    use HasFactory;

    protected $table = 'finalizacion_gestacion'; 

    protected $primaryKey = 'cod_finalizacion'; 

    public $timestamps = false;

    protected $fillable = [
        'cod_finalizacion',
        'id_usuario',
        'id_operador',
        'cod_terminacion', 
        'fec_evento',
    ];

    
    public function terminacion()
    {
        return $this->belongsTo(TerminacionGestacion::class, 'cod_terminacion', 'cod_terminacion');
    }
}
