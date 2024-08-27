<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormaMedicionEdadGestacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('forma_medicion_edad_gestacional', function (Blueprint $table) {
        $table->id('cod_medicion'); // Clave primaria
        
        // Forma de medición
        $table->string('nom_forma'); // 1-Fur confiable, 2-Fur no confiable, 3-Ecografia
        
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forma_medicion_edad_gestacional');
    }
}
