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
        'documento_usuario',
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

    public function controlesPrenatales()
    {
        return $this->hasMany(ControlPrenatal::class, 'id_usuario', 'id_usuario');
    }

    public function primeraConsultas()
    {
        return $this->hasMany(PrimeraConsulta::class, 'id_usuario');
    }

    public function vacunaciones()
    {
        return $this->hasMany(Vacunacion::class, 'id_usuario');
    }

    public function laboratorios()
    {
        return $this->hasMany(LaboratorioITrimestre::class, 'id_usuario', 'id_usuario');
    }

    public function laboratorios2()
    {
        return $this->hasMany(LaboratorioIITrimestre::class, 'id_usuario', 'id_usuario');
    }

    public function its()
    {
        return $this->hasMany(Its::class, 'id_usuario', 'id_usuario');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoConsultaMensual::class, 'id_usuario');
    }

    public function procesosGestativos()
    {
        return $this->hasMany(ProcesoGestativo::class, 'id_usuario');
    }
}
