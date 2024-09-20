<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biologico extends Model
{
    use HasFactory;
    protected $table = 'biologico';

    protected $primaryKey = 'cod_biologico';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nom_biologico'];

    public function vacunaciones()
    {
        return $this->hasMany(Vacunacion::class, 'cod_biologico');
    }
}
