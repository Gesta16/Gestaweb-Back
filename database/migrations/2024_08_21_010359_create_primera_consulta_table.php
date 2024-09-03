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
            $table->integer('cod_consulta')->primary();

            $table->integer('cod_opexusu');
            $table->foreign('cod_opexusu')->references('cod_opexusu')->on('operadorxusuario');

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->integer('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->integer('cod_riesgo');
            $table->foreign('cod_riesgo')->references('cod_riesgo')->on('riesgo');

            $table->integer('cod_dm');
            $table->foreign('cod_dm')->references('cod_dm')->on('tipo_dm');

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
            $table->date('fec_lactancia');
            $table->date('fec_consejeria');

            //$table->timestamps();
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
