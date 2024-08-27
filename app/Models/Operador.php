<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'operador'; 


    protected $fillable = [
        'id_operador',
        'id_admin',
        'nom_operador',
        'ape_operador',
        'tel_operador',
        'email_operador',
        'esp_operador',
        'usu_operador',
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
