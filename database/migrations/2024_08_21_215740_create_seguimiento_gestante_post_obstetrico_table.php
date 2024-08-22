<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientoGestantePostObstetricoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('seguimiento_gestante_post_obstetrico', function (Blueprint $table) {
        $table->integer('cod_evento')->primary(); // Clave primaria
        
        // Clave foránea
        $table->unsignedBigInteger('cod_metodo'); // FK a la tabla de métodos anticonceptivos
        
        // Campos adicionales
        $table->string('con_egreso');           // Condición al egreso tras el parto o aborto (Vivo, Muerto)
        $table->date('fec_fallecimiento')->nullable(); // Fecha del fallecimiento
        $table->date('fec_planificacion')->nullable(); // Fecha de atención de planificación familiar posparto

        // Definir la relación
        $table->foreign('cod_metodo')->references('cod_metodo')->on('metodos_anticonceptivos');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimiento_gestante_post_obstetrico');
    }
}
