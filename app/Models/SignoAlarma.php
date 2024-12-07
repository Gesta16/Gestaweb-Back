<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignoAlarma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'consejo'
    ];
}
