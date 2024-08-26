<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'id_usuario', 'cod_depxips', 'cod_departamento', 'cod_ips', 'cod_documento', 'cod_poblacion', 'fec_diag_usuario', 'fec_ingreso', 'nom_usuario', 'ape_usuario', 'fec_nacimiento', 'edad_nacimiento', 'tel_usuario', 'cel_usuario', 'dir_usuario', 'email_usuario',
    ];

    public $timestamps= false;
}
