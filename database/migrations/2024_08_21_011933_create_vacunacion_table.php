<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacunacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacunacion', function (Blueprint $table) {
            $table->integer('cod_vacunacion')->primary();

            $table->integer('cod_opexusu');
            $table->foreign('cod_opexusu')->references('cod_opexusu')->on('operadorxusuario');

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->integer('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->unsignedBigInteger('cod_biologico');
            $table->foreign('cod_biologico')->references('cod_biologico')->on('biologico');

            $table->date('fec_unocovid');
            $table->date('fec_doscovid');
            $table->date('fec_refuerzo');
            $table->date('fec_influenza');
            $table->date('fec_tetanico');
            $table->date('fec_dpt');
            
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
        Schema::dropIfExists('vacunacion');
    }
}
