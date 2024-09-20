<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riesgo extends Model
{
    use HasFactory;

    protected $table = 'riesgo';

    protected $primaryKey = 'cod_riesgo';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_riesgo'];

    public function primeraConsultas()
    {
        return $this->hasMany(PrimeraConsulta::class, 'cod_riesgo');
    }
}
