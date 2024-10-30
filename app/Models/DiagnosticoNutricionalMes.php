<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticoNutricionalMes extends Model
{
    use HasFactory;

    protected $table = 'diagnostico_nutricional_mes';

    protected $primaryKey = 'cod_diagnostico';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_diagnostico'];

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoConsultaMensual::class, 'cod_diagnostico');
    }
}
