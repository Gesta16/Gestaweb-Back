<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminacionGestaciónTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('terminacion_gestacion', function (Blueprint $table) {
        $table->id('cod_terminacion'); // Clave primaria
        
        // Tipo de terminación
        $table->string('nom_terminacion'); // Parto vaginal, cesárea, aborto, mortalidad perinatal, IVE

    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
