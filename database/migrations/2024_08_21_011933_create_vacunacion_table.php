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
