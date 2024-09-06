<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebaNoTreponemicaRPR extends Model
{
    use HasFactory;
    protected $table = 'prueba_no_treponemica__r_p_r';

    protected $primaryKey = 'cod_rpr';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['num_rpr'];
}
