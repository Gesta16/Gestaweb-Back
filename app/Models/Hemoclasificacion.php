<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hemoclasificacion extends Model
{
    use HasFactory;

    protected $table = 'hemoclasificacion';

    protected $primaryKey = 'cod_hemoclasifi';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['tip_hemoclasificacion'];

    public function laboratorios()
    {
        return $this->hasMany(LaboratorioITrimestre::class, 'cod_hemoclasifi', 'cod_hemoclasifi');
    }
}
