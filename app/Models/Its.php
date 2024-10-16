<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Its extends Model
{
    use HasFactory;

      protected $table = 'its';

      protected $primaryKey = 'cod_its';

      public $timestamps = false;

  
      protected $fillable = [
          'id_operador',
          'id_usuario',
          'cod_vdrl',
          'cod_rpr',
          'eli_vih',
          'fec_vih',
          'fec_vdrl',
          'fec_rpr',
          'rec_tratamiento',
          'rec_pareja',
          'proceso_gestativo_id'

      ];
  
  
      public function operador()
      {
          return $this->belongsTo(Operador::class, 'id_operador', 'id_operador');
      }
  
      public function usuario()
      {
          return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
      }
  
      public function vdrl()
      {
          return $this->belongsTo(PruebaNoTreponemicaVDrl::class, 'cod_vdrl', 'cod_vdrl');
      }
  
      public function rpr()
      {
          return $this->belongsTo(PruebaNoTreponemicaRpr::class, 'cod_rpr', 'cod_rpr');
      }
}
