<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortalidadPreparto extends Model
{
    use HasFactory;

    protected $table = 'mortalidad_preparto'; 

    protected $primaryKey = 'cod_mortalpreparto'; 

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_operador',
        'cod_mortalpreparto',
        'cod_mortalidad',
        'fec_defuncion',
        'proceso_gestativo_id'
    ];

    
    public function mortalidadPerinatal()
    {
        return $this->belongsTo(MortalidadPerinatal::class, 'cod_mortalidad', 'cod_mortalidad');
    }
}
