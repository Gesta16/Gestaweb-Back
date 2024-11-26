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
        $table->string('eli_vih')->nullable();               // Elisa para VIH (reactivo, no reactivo)
        $table->date('fec_vih')->nullable();                 // Fecha elisa para VIH
        $table->date('fec_vdrl')->nullable();                // Fecha prueba no treponémica (VDRL)
        $table->date('fec_rpr')->nullable();                 // Fecha prueba no treponémica (RPR)
        $table->string('rec_tratamiento')->nullable();       // Recibió tratamiento para sífilis (si, no)
        $table->string('rec_pareja')->nullable();            // Recibió tratamiento para sífilis para la pareja
        $table->boolean('reali_prueb_elisa_vih');// Realizó la prueba Elisa para VIH
        $table->boolean('reali_prueb_no_trepo_vdrl_sifilis'); //Realizó la prueba no treponémica (VDRL) para sífilis
        $table->boolean('reali_prueb_no_trepo_rpr_sifilis'); //Realizó la prueba no treponémica (RPR) para sífilis
        

        // Definir las relaciones
        $table->foreign('cod_vdrl')->references('cod_vdrl')->on('prueba_no_treponemica__v_d_r_l');
        $table->foreign('cod_rpr')->references('cod_rpr')->on('prueba_no_treponemica__r_p_r')->nullable();
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
