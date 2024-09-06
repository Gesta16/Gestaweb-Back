<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoFracaso extends Model
{
    use HasFactory;

    protected $table = 'metodo_fracaso';

    protected $primaryKey = 'cod_fracaso';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_fracaso'];
}
