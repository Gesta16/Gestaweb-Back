<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalizacionGestacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finalizacion_gestacion', function (Blueprint $table) {
            $table->id('cod_finalizacion'); // Clave primaria
            
            // Clave foránea
            $table->unsignedBigInteger('cod_terminacion'); // FK a la tabla de terminación
            
            // Fecha del evento obstétrico
            $table->date('fec_evento'); 
                
            // Definir la relación
            $table->foreign('cod_terminacion')->references('cod_terminacion')->on('terminacion_gestacion');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finalizacion_gestacion');
    }
}
