<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratorioIIITrimestre extends Model
{
    use HasFactory;

    protected $table = 'laboratorio_iii_trimestre';
    protected $primaryKey = 'cod_treslaboratorio'; 

    public $timestamps = false;

    protected $fillable = [
        'id_operador',
        'id_usuario',
        'hemograma',
        'fec_hemograma',
        'pru_vih',
        'fec_vih',
        'pru_sifilis',
        'fec_sifilis',
        'ig_toxoplasma',
        'fec_toxoplasma',
        'cul_rectal',
        'fec_rectal',
        'fec_biofisico',
        'edad_gestacional',
        'rie_biopsicosocial',
    ];

    public function operador()
    {
        return $this->belongsTo(Operador::class, 'id_operador', 'id_operador');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
