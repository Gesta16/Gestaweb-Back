<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Micronutriente extends Model
{
    use HasFactory;

    
    protected $table = 'micronutrientes';
    
    protected $primaryKey = 'cod_micronutriente';

    public $timestamps = false;

    
    protected $fillable = [
        'cod_micronutriente',
        'id_usuario',
        'id_operador',
        'aci_folico',
        'sul_ferroso',
        'car_calcio',
        'desparasitacion',
        'proceso_gestativo_id'
    ];
}
