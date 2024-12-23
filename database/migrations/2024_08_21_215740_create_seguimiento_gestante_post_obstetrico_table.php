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
        $table->id('cod_evento');// Clave primaria
        
        // Clave foránea
        $table->unsignedBigInteger('id_operador');
        $table->foreign('id_operador')->references('id_operador')->on('operador');

        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        $table->unsignedBigInteger('cod_metodo'); // FK a la tabla de métodos anticonceptivos
        
        $table->foreignId('proceso_gest_id')->constrained('procesos_gestativos');

        // Campos adicionales
        $table->string('con_egreso');           // Condición al egreso tras el parto o aborto (Vivo, Muerto)
        $table->date('fec_fallecimiento')->nullable(); // Fecha del fallecimiento
        $table->date('fec_planificacion')->nullable(); // Fecha de atención de planificación familiar posparto
        $table->boolean('recib_aseso_anticonceptiva');

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
