<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumSesionesCursoPaternidadMaternidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('num_sesiones_curso_paternidad_maternidad', function (Blueprint $table) {
        $table->id('cod_sesiones'); // Clave primaria
        
        // Número de sesiones del 0 al 13
        $table->integer('num_sesiones'); 
        
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('num_sesiones_curso_paternidad_maternidad');
    }
}
