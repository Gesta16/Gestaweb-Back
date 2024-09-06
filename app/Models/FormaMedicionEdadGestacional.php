<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaMedicionEdadGestacional extends Model
{
    use HasFactory;

    protected $table = 'forma_medicion_edad_gestacional';

    protected $primaryKey = 'cod_medicion';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_forma'];
}
