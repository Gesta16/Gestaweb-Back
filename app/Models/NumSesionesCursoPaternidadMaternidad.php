<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumSesionesCursoPaternidadMaternidad extends Model
{
    use HasFactory;
    
    protected $table = 'num_sesiones_curso_paternidad_maternidad';

    protected $primaryKey = 'cod_sesiones';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['num_sesiones'];
}
