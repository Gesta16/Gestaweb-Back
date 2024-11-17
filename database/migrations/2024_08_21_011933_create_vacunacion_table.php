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
            $table->id('cod_vacunacion');

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->unsignedBigInteger('cod_biologico');
            $table->foreign('cod_biologico')->references('cod_biologico')->on('biologico');

            $table->date('fec_unocovid')->nullable();
            $table->date('fec_doscovid')->nullable();
            $table->date('fec_refuerzo')->nullable();
            $table->date('fec_influenza')->nullable();
            $table->date('fec_tetanico')->nullable();
            $table->date('fec_dpt')->nullable();
            $table->boolean('recib_prim_dosis_covid19');//Recibió la primera dosis covid 19
            $table->boolean('recib_segu_dosis_covid19');//Recibió la segunda dosis covid 19
            $table->boolean('recib_refu_covid19');//Recibió el refuerzo covid 19
            $table->boolean('recib_dosis_influenza');//Recibió la dosis influenza
            $table->boolean('recib_dosis_tox_tetanico');//Recibió la dosis toxoide tetánico
            $table->boolean('recib_dosis_dpt_a_celular');//Recibió la dosis DPT a-celular
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
