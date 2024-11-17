<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoriosIntrapartoGestanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('laboratorios_intraparto_gestante', function (Blueprint $table) {
        $table->id('cod_intraparto'); // Clave primaria
        
        // Clave foránea
        $table->unsignedBigInteger('id_operador');
        $table->foreign('id_operador')->references('id_operador')->on('operador');

        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        $table->unsignedBigInteger('cod_vdrl'); // FK a la tabla de pruebas no treponémicas (VDRL)
        $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

        
        // Campos adicionales
        $table->string('pru_sifilis');        // Prueba treponémica rápida para sífilis intraparto
        $table->date('fec_sifilis');          // Fecha prueba treponémica rápida para sífilis intraparto
        $table->date('fec_vdrl');             // Fecha prueba no treponémica (VDRL) para sífilis intraparto
        $table->string('rec_sifilis');        // Recibió tratamiento para sífilis intraparto (sí, no)
        $table->date('fec_tratamiento');      // Fecha de inicio de tratamiento para sífilis intraparto
        $table->string('pru_vih');            // Prueba rápida VIH intraparto (positivo, negativo)
        $table->date('fec_vih');              // Fecha prueba rápida VIH intraparto
        $table->boolean('reali_prueb_trepo_rapi_sifilis_intra');//Realizó la prueba treponémica rápida para sífilis intraparto
        $table->boolean('reali_prueb_no_trepo_vdrl_sifilis_intra');//Realizó la prueba no treponémica (VDRL) para sífilis intraparto
        $table->boolean('reali_prueb_rapi_vih');//Realizó la Prueba rápida VIH

        $table->foreign('cod_vdrl')->references('cod_vdrl')->on('prueba_no_treponemica__v_d_r_l');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratorios_intraparto_gestante');
    }
}
