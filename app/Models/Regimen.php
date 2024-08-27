<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ips;

class Regimen extends Model
{
    use HasFactory;

    protected $table = 'regimen';

    protected $primaryKey = 'cod_regimen';

    public $timestamps = false; 

    protected $fillable = [
        'cod_regimen',
        'nom_regimen',
    ];

    public function ips()
    {
        return $this->hasMany(Ips::class, 'cod_regimen', 'cod_regimen');
    }
}
