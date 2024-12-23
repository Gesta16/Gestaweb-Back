<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class SuperAdmin extends Model
{
    use HasFactory;

    protected $table = 'superadmin'; 
    protected $primaryKey = 'id_superadmin'; 


    public $timestamps = false;


    protected $fillable = [
        'nom_superadmin',
        'ape_superadmin',
        'documento_superadmin',
        'email_superadmin',
        'tel_superadmin',
        'cod_documento',

        
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
