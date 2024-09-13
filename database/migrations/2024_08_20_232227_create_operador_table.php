<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operador', function (Blueprint $table) {
            $table->id('id_operador');
            $table->unsignedBigInteger('id_admin');

            $table->unsignedBigInteger('cod_ips');

            $table->foreign('cod_ips')->references('cod_ips')->on('ips');

            $table->foreign('id_admin')->references('id_admin')->on('admin');

            $table->string('nom_operador');
            $table->string('ape_operador');

            $table->unsignedBigInteger('cod_documento');
            $table->foreign('cod_documento')->references('cod_documento')->on('tipo_de_documento');

            $table->unsignedBigInteger('cod_departamento');
            $table->foreign('cod_departamento')->references('cod_departamento')->on('departamento');

            $table->unsignedBigInteger('cod_municipio');
            $table->foreign('cod_municipio')->references('cod_municipio')->on('municipio');

            $table->string('documento_operador')->unique();
            $table->integer('tel_operador')->unique();
            $table->string('email_operador')->unique();
            $table->string('esp_operador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operador');
    }
}
