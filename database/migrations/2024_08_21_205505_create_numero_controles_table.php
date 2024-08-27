<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumeroControlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('numero_controles', function (Blueprint $table) {
        $table->id('cod_controles'); // Clave primaria
        
        // Número de controles del 1 al 13
        $table->integer('num_control'); 
        
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
        Schema::dropIfExists('numero_controles');
    }
}
