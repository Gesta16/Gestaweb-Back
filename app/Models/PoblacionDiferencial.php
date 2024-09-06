<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoblacionDiferencial extends Model
{
    use HasFactory;

    protected $table = 'poblacion_diferencial';

    protected $primaryKey = 'cod_poblacion';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_poblacion'];
}
