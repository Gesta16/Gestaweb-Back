<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioSignoAlarma extends Model
{
    protected $table = 'usuario_signo_alarma';
    protected $fillable = ['usuario_id', 'signo_alarma_id'];
}