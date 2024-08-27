<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamento'; 

    protected $fillable = [
        'cod_departamento',
        'nom_departamento',
    ];

    public $timestamps = false;

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'cod_departamento', 'cod_departamento');
    }
}
