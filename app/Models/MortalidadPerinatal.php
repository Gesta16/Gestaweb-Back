<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortalidadPerinatal extends Model
{
    use HasFactory;

    protected $table = 'mortalidad_perinatal';

    protected $primaryKey = 'cod_mortalidad';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'cla_muerte',

    ];
}
