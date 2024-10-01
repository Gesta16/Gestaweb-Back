<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortalidadPrepartoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortalidad_preparto', function (Blueprint $table) {
            $table->id('cod_mortalpreparto');

            $table->unsignedBigInteger('cod_mortalidad');
            $table->foreign('cod_mortalidad')->references('cod_mortalidad')->on('mortalidad_perinatal');

            $table->date('fec_defuncion');
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
        Schema::dropIfExists('mortalidad_preparto');
    }
}
