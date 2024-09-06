<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'tipo_de_documento';

    protected $primaryKey = 'cod_documento';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_documento'];
}

