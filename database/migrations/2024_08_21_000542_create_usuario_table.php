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
            $table->id('id_usuario');
            
            $table->unsignedBigInteger('cod_departamento');
            $table->foreign('cod_departamento')->references('cod_departamento')->on('departamento');

            $table->unsignedBigInteger('cod_municipio');
            $table->foreign('cod_municipio')->references('cod_municipio')->on('municipio');
            
            $table->unsignedBigInteger('cod_ips');
            $table->foreign('cod_ips')->references('cod_ips')->on('ips');

            $table->unsignedBigInteger('cod_documento');
            $table->foreign('cod_documento')->references('cod_documento')->on('tipo_de_documento');
            $table->string('documento_usuario')->unique();

            $table->unsignedBigInteger('cod_poblacion');
            $table->foreign('cod_poblacion')->references('cod_poblacion')->on('poblacion_diferencial');

            $table->date('fec_diag_usuario');
            $table->date('fec_ingreso');
            $table->string('nom_usuario');
            $table->string('ape_usuario');
            $table->date('fec_nacimiento');
            $table->integer('edad_usuario');
            $table->string('tel_usuario')->unique();
            $table->string('cel_usuario')->unique();
            $table->string('dir_usuario');
            $table->string('email_usuario')->unique();
            $table->integer('num_proceso')->default(1);
            $table->boolean('autorizacion')->default(false);



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
