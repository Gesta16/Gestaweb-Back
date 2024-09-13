<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'operador'; 

    protected $primaryKey = 'id_operador';



    protected $fillable = [
        'id_operador',
        'id_admin',
        'cod_ips',
        'nom_operador',
        'ape_operador',
        'tel_operador',
        'email_operador',
        'cod_departamento',
        'cod_municipio',
        'esp_operador',
        'documento_operador',
        'cod_documento',

    ];
    public $timestamps = false;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
