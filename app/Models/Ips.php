<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Regimen;
use App\Models\Admin;

class Ips extends Model
{
    use HasFactory;


    protected $table = 'ips';

    protected $primaryKey = 'cod_ips';

    public $timestamps = false;

    protected $fillable = [
        'cod_ips',
        'cod_regimen',
        'nom_ips',
        'dir_ips',
        'tel_ips',
        'email_ips',
    ];

    public function regimen()
    {
        return $this->belongsTo(Regimen::class, 'cod_regimen', 'cod_regimen');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'cod_ips', 'cod_ips');
    }

}
