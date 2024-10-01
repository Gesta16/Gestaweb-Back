<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebaNoTreponemicaVDRL extends Model
{
    use HasFactory;

    protected $table = 'prueba_no_treponemica__v_d_r_l';

    protected $primaryKey = 'cod_vdrl';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['num_vdrl'];

    public function its()
    {
        return $this->hasMany(Its::class, 'cod_vdrl', 'cod_vdrl');
    }
    
}
