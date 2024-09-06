<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoAnticonceptivo extends Model
{
    use HasFactory;

    protected $table = 'metodos_anticonceptivos';

    protected $primaryKey = 'cod_metodo';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_metodo'];
}
