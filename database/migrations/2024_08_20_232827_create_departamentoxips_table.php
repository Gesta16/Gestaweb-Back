<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentoxipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentoxips', function (Blueprint $table) {
            $table->integer('cod_depxips');
            $table->unsignedBigInteger('cod_ips');
            
            $table->primary(['cod_depxips', 'cod_departamento', 'cod_ips']); //Llave compuesta
            
            $table->integer('cod_departamento');
            $table->foreign('cod_departamento')->references('cod_departamento')->on('departamento');

            $table->foreign('cod_ips')->references('cod_ips')->on('ips');

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
        Schema::dropIfExists('departamentoxips');
    }
}
