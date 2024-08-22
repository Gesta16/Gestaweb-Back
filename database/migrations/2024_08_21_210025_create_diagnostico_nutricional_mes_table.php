<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticoNutricionalMesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('diagnostico_nutricional_mes', function (Blueprint $table) {
        $table->id('cod_diagnostico'); // Clave primaria
        
        // Diagnóstico nutricional
        $table->string('nom_diagnostico'); // IMC adecuado para la edad gestacional, Bajo peso para la edad gestacional, Sobrepeso para la edad gestacional, Obesidad para la edad gestacional
        
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
        Schema::dropIfExists('diagnostico_nutricional_mes');
    }
}
