<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlPrenatalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_prenatal', function (Blueprint $table) {
            $table->integer('cod_control')->primary();

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->unsignedBigInteger('cod_fracaso');
            $table->foreign('cod_fracaso')->references('cod_fracaso')->on('metodo_fracaso');

            $table->decimal('edad_gestacional', 4, 1);
            $table->string('trim_ingreso');
            $table->date('fec_mestruacion');
            $table->date('fec_parto');
            $table->boolean('emb_planeado');
            $table->boolean('fec_anticonceptivo');
            $table->date('fec_consulta');
            $table->date('fec_control');
            $table->string('ries_reproductivo');
            $table->date('fac_asesoria');
            $table->boolean('usu_solicito');
            $table->date('fec_terminacion');
            $table->boolean('per_intergenesico');

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
        Schema::dropIfExists('control_prenatal');
    }
}
