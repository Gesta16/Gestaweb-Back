<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortalidadPerinatalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('mortalidad_perinatal', function (Blueprint $table) {
        $table->id('cod_mortalidad'); // Clave primaria
        
        $table->string('cla_muerte');                // Clasificación según momento de muerte (Perinatal, neonatal temprana, neonatal tardía, Aborto (Menor a 22 semanas), mortalidad perinatal- dejar en blanco)
        
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mortalidad_perinatal');
    }
}
