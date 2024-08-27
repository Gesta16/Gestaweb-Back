<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodosAnticonceptivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodos_anticonceptivos', function (Blueprint $table) {
            $table->id('cod_metodo'); // Clave primaria
            
            // Nombre del método anticonceptivo
            $table->string('nom_metodo'); // Inyectable trimestral, inyectable mensual, oral, implante subdérmico, DIU T, preservativo, emergencia, esterilización
            
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metodos_anticonceptivos');
    }
}
