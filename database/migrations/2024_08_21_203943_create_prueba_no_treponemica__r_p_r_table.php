<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePruebaNoTreponemicaRPRTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('prueba_no_treponemica__r_p_r', function (Blueprint $table) {
        $table->id('cod_rpr'); // Clave primaria
        
        // Valores posibles: No reactivo, 1:2, 1:4, 1:8, 1:16, 1:32, 1:64, 1:128, 1:256
        $table->string('num_rpr');
        
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prueba_no_treponemica__r_p_r');
    }
}
