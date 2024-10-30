<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('its', function (Blueprint $table) {
        $table->id('cod_its'); // Primary Key

        $table->unsignedBigInteger('id_operador');
        $table->foreign('id_operador')->references('id_operador')->on('operador');

        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

        $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

        // Claves foráneas
        $table->unsignedBigInteger('cod_vdrl');  
        $table->unsignedBigInteger('cod_rpr'); 

        // Otros campos
        $table->string('eli_vih');               // Elisa para VIH (reactivo, no reactivo)
        $table->date('fec_vih');                 // Fecha elisa para VIH
        $table->date('fec_vdrl');                // Fecha prueba no treponémica (VDRL)
        $table->date('fec_rpr');                 // Fecha prueba no treponémica (RPR)
        $table->string('rec_tratamiento');       // Recibió tratamiento para sífilis (si, no)
        $table->string('rec_pareja');            // Recibió tratamiento para sífilis para la pareja

        // Definir las relaciones
        $table->foreign('cod_vdrl')->references('cod_vdrl')->on('prueba_no_treponemica__v_d_r_l');
        $table->foreign('cod_rpr')->references('cod_rpr')->on('prueba_no_treponemica__r_p_r');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('its');
    }
}
