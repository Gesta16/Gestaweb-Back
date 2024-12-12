<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'autorizacion'
    ];

    public $timestamps = false;

    // Relación con el modelo User
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    // Relación con controles prenatales
    public function controlesPrenatales()
    {
        return $this->hasMany(ControlPrenatal::class, 'id_usuario', 'id_usuario');
    }

    // Relación con primera consulta
    public function primeraConsultas()
    {
        return $this->hasMany(PrimeraConsulta::class, 'id_usuario');
    }

    // Relación con vacunaciones
    public function vacunaciones()
    {
        return $this->hasMany(Vacunacion::class, 'id_usuario');
    }

    // Relación con laboratorios del primer trimestre
    public function laboratorios()
    {
        return $this->hasMany(LaboratorioITrimestre::class, 'id_usuario', 'id_usuario');
    }

    // Relación con laboratorios del segundo trimestre
    public function laboratorios2()
    {
        return $this->hasMany(LaboratorioIITrimestre::class, 'id_usuario', 'id_usuario');
    }

    // Relación con ITS
    public function its()
    {
        return $this->hasMany(Its::class, 'id_usuario', 'id_usuario');
    }

    // Relación con seguimientos mensuales
    public function seguimientos()
    {
        return $this->hasMany(SeguimientoConsultaMensual::class, 'id_usuario');
    }

    public function signosAlarmas()
    {
        return $this->belongsToMany(SignoAlarma::class, 'usuario_signo_alarma', 'usuario_id', 'signo_alarma_id');
    }


    // Relación con procesos gestativos
    public function procesosGestativos()
    {
        return $this->hasMany(ProcesoGestativo::class, 'id_usuario');
    }

    // Relación con datos del recién nacido
    public function datosRecienNacido()
    {
        return $this->hasMany(DatosRecienNacido::class, 'id_usuario', 'id_usuario');
    }

    // Relación con finalización de gestación
    public function finalizacionGestacion()
    {
        return $this->hasMany(FinalizacionGestacion::class, 'id_usuario', 'id_usuario');
    }

    // Relación con tamización neonatal
    public function tamizacionNeonatal()
    {
        return $this->hasMany(TamizacionNeonatal::class, 'id_usuario', 'id_usuario');
    }

    // Relación con micronutrientes
    public function micronutrientes()
    {
        return $this->hasMany(Micronutriente::class, 'id_usuario', 'id_usuario');
    }

    // Relación con mortalidad preparto
    public function mortalidadPreparto()
    {
        return $this->hasMany(MortalidadPreparto::class, 'id_usuario', 'id_usuario');
    }

    // Relación con seguimientos complementarios
    public function seguimientosComplementarios()
    {
        return $this->hasMany(SeguimientoComplementario::class, 'id_usuario', 'id_usuario');
    }

    // Relación con hipotiroidismo congénito
    public function hipotiroidismoCongenito()
    {
        return $this->hasMany(EstudioHipotiroidismoCongenito::class, 'id_usuario', 'id_usuario');
    }

    // Relación con laboratorios del tercer trimestre
    public function laboratorios3()
    {
        return $this->hasMany(LaboratorioIIITrimestre::class, 'id_usuario', 'id_usuario');
    }

    // Relación con laboratorios intraparto
    public function laboratoriosIntraparto()
    {
        return $this->hasMany(LaboratorioInTraparto::class, 'id_usuario', 'id_usuario');
    }

    // Relación con seguimiento post-obstétrico
    public function seguimientoPostObstetrico()
    {
        return $this->hasMany(SeguimientoGestantePostObstetrico::class, 'id_usuario', 'id_usuario');
    }

    // Relación con las notas de usuario
    public function userNotes()
    {
        return $this->hasMany(UserNote::class, 'id_usuario');
    }

    // Relación con IPS
    public function ips()
    {
        return $this->belongsTo(Ips::class, 'cod_ips', 'cod_ips');
    }
}
