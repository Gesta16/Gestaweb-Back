<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminacionGestacion extends Model
{
    use HasFactory;

    protected $table = 'terminacion_gestacion';

    protected $primaryKey = 'cod_terminacion';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_terminacion'];
}
