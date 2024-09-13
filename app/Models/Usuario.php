<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario'; 

    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_usuario',
        'cod_departamento',
        'cod_municipio',
        'cod_ips',
        'cod_documento',
        'cod_poblacion',
        'fec_diag_usuario',
        'fec_ingreso',
        'nom_usuario',
        'ape_usuario',
        'fec_nacimiento',
        'edad_usuario',
        'tel_usuario',
        'cel_usuario',
        'dir_usuario',
        'email_usuario',
    ];

    public $timestamps = false;


    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
