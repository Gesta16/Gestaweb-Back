<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antibiograma extends Model
{
    use HasFactory;

    protected $table = 'antibiograma';

    protected $primaryKey = 'cod_antibiograma';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_antibiograma'];

    public function laboratorios()
    {
        return $this->hasMany(LaboratorioITrimestre::class, 'cod_antibiograma', 'cod_antibiograma');
    }
}
