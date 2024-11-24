<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTamizacionNeonatalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tamizacion_neonatal', function (Blueprint $table) {
            $table->id('cod_tamizacion');

            $table->unsignedBigInteger('cod_hemoclasifi');
            $table->foreign('cod_hemoclasifi')->references('cod_hemoclasifi')->on('hemoclasificacion');

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');


            $table->date('fec_tsh');
            $table->string('resul_tsh');
            $table->date('fec_pruetrepo')->nullable();
            $table->string('pruetreponemica')->nullable();
            $table->string('tamiza_aud')->nullable();
            $table->string('tamiza_cardi')->nullable();
            $table->string('tamiza_visual')->nullable();
            $table->boolean('reali_prueb_trepo_recien_nacido');//Se realizó la Prueba no treponémica recién nacido
            $table->boolean('reali_tami_auditivo');///Se realizó el Tamizaje auditivo
            $table->boolean('reali_tami_cardiopatia_congenita');//Se realizó el Tamizaje cardiopatías congénitas
            $table->boolean('reali_tami_visual');//Se realizó el Tamizaje visual
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tamizacion_neonatal');
    }
}
