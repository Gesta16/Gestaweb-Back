<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departamento;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipio'; 

    protected $primaryKey = 'cod_municipio';


    protected $fillable = [
        'cod_municipio',
        'cod_departamento',
        'nom_municipio',
    ];

    public $timestamps = false;

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'cod_departamento', 'cod_departamento');
    }
}
