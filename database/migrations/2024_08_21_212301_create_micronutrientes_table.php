<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicronutrientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micronutrientes', function (Blueprint $table) {
            $table->integer('cod_micronutriente')->primary(); // Clave primaria

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
            
            // Campos adicionales
            $table->string('aci_folico');         // Ácido fólico (sí, no)
            $table->string('sul_ferroso');        // Sulfato ferroso (sí, no)
            $table->string('car_calcio');         // Carbonato de calcio (sí, no)
            $table->string('desparasitacion');    // Desparasitación (sí, no)
    
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('micronutrientes');
    }
}
