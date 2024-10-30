<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDm extends Model
{
    use HasFactory;

    protected $table = 'tipo_dm';

    protected $primaryKey = 'cod_dm';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['tip_dm'];

    public function primeraConsultas()
    {
        return $this->hasMany(PrimeraConsulta::class, 'cod_dm');
    }
}
