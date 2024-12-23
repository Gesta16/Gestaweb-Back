<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrimeraConsultaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primera_consulta', function (Blueprint $table) {
            $table->id('cod_consulta');

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->unsignedBigInteger('cod_riesgo');
            $table->foreign('cod_riesgo')->references('cod_riesgo')->on('riesgo');

            $table->unsignedBigInteger('cod_dm')->nullable();
            $table->foreign('cod_dm')->references('cod_dm')->on('tipo_dm');

            $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

            $table->integer('peso_previo');
            $table->decimal('tal_consulta', 8, 2);
            $table->integer('imc_consulta');
            $table->string('diag_nutricional');
            $table->integer('hta');
            $table->integer('dm');
            $table->string('fact_riesgo');
            $table->string('expo_violencia');
            $table->string('ries_depresion');
            $table->integer('for_gestacion');
            $table->integer('for_parto');
            $table->integer('for_cesarea');
            $table->integer('for_aborto');
            $table->date('fec_lactancia')->nullable();
            $table->date('fec_consejeria')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('asis_conse_lactancia');//Asistió a la consejería lactancia materna
            $table->boolean('asis_conse_pre_vih');//Asistió a la consejería pretest VIH
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_primera_consulta');
    }
}
