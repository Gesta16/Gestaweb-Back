<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacunacion extends Model
{
    use HasFactory;

    protected $table = 'vacunacion';
    protected $primaryKey = 'cod_vacunacion';
    public $timestamps = false;

    protected $fillable = [
        'id_operador',
        'id_usuario',
        'cod_biologico',
        'fec_unocovid',
        'fec_doscovid',
        'fec_refuerzo',
        'fec_influenza',
        'fec_tetanico',
        'fec_dpt',
        'reci_primer_dosis_covid',
        'reci_segu_dosis_covid',
        'reci_refue_covid',
        'reci_dosis_influenza',
        'reci_dosis_toxo_tetanico',
        'reci_dosis_dpt_a_celular'

    ];

    // Relaciones
    public function operador()
    {
        return $this->belongsTo(Operador::class, 'id_operador');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function biologico()
    {
        return $this->belongsTo(Biologico::class, 'cod_biologico');
    }
}
