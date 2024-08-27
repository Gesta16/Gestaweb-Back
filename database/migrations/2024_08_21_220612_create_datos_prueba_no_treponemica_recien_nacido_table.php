<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosPruebaNoTreponemicaRecienNacidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('datos_prueba_no_treponemica_recien_nacido', function (Blueprint $table) {
        $table->id('cod_treponemica'); // Clave primaria
        
        // Campos adicionales
        $table->string('nom_treponemica'); // Resultado de la prueba (No reactivo, 1:2, 1:4, 1:8, 1:16, 1:32, 1:64, 1:128, 1:256)
        
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_prueba_no_treponemica_recien_nacido');
    }
}
