<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignoAlarma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_signo_alarma', 'signo_alarma_id', 'usuario_id');
    }
}
