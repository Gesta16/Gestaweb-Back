<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Ips;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin'; 
    protected $primaryKey = 'id_admin'; 


    public $timestamps = false;

    protected $fillable = [
        'id_admin',
        'cod_ips',
        'nom_admin',
        'ape_admin',
        'cod_departamento',
        'cod_municipio',
        'email_admin',
        'tel_admin',
        'cod_documento',

    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function ips()
    {
        return $this->belongsTo(Ips::class, 'cod_ips', 'cod_ips');
    }
}

