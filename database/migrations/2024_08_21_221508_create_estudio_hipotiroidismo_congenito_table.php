<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudioHipotiroidismoCongenitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('estudio_hipotiroidismo_congenito', function (Blueprint $table) {
        $table->id('cod_estudio'); // Clave primaria

        $table->unsignedBigInteger('id_operador');
        $table->foreign('id_operador')->references('id_operador')->on('operador');

        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

        $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

        
        // Campos adicionales
        $table->string('tsh');                   // TSH de seguimiento
        $table->date('fec_resultado');          // Fecha de resultado TSH de seguimiento
        $table->string('t4_libre');             // T4 libre
        $table->date('fec_resultadot4');        // Fecha de resultado T4 libre
        $table->string('eve_confirmado');       // Evento confirmado (Si, No)
        $table->date('fec_primera');            // Fecha primera consulta pediatría
        
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudio_hipotiroidismo_congenito');
    }
}
