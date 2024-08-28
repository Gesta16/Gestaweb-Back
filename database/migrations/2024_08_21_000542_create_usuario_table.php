<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->integer('id_usuario')->primary();
            
            $table->integer('cod_depxips');
            $table->foreign('cod_depxips')->references('cod_depxips')->on('departamentoxips'); //Debe ser auto incremental??

            $table->integer('cod_departamento');
            $table->foreign('cod_departamento')->references('cod_departamento')->on('departamentoxips');

            $table->unsignedBigInteger('cod_ips');
            $table->foreign('cod_ips')->references('cod_ips')->on('departamentoxips');

            $table->integer('cod_documento');
            $table->foreign('cod_documento')->references('cod_documento')->on('tipo_de_documento');

            $table->integer('cod_poblacion');
            $table->foreign('cod_poblacion')->references('cod_poblacion')->on('poblacion_diferencial');

            $table->date('fec_diag_usuario');
            $table->date('fec_ingreso');
            $table->string('nom_usuario');
            $table->string('ape_usuario');
            $table->date('fec_nacimiento');
            $table->integer('edad_usuario');
            $table->integer('tel_usuario')->unique();
            $table->integer('cel_usuario')->unique();
            $table->string('dir_usuario');
            $table->string('email_usuario')->unique();


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
        Schema::dropIfExists('usuario');
    }
}
