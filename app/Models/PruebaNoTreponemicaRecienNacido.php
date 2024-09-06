<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebaNoTreponemicaRecienNacido extends Model
{
    use HasFactory;

    protected $table = 'datos_prueba_no_treponemica_recien_nacido';

    protected $primaryKey = 'cod_treponemica';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_treponemica'];
}
