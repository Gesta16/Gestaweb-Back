<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoGestativo extends Model
{
    use HasFactory;

    protected $table = 'procesos_gestativos';
    public $timestamps = false;



    protected $fillable = [
        'usuario_id', 
        'estado',     
        'num_proceso', 
    ];

    /**
     * Relación con el modelo Usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
