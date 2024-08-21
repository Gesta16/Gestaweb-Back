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
            $table->integer('id_operador')->primary();
            $table->integer('id_admin');

            $table->foreign('id_admin')->references('id_admin')->on('admin');

            $table->string('nom_operador');
            $table->string('ape_operador');
            $table->integer('tel_operador')->unique();
            $table->string('email_operador')->unique();
            $table->string('esp_operador');
            $table->string('usu_operador');
            $table->string('cont_operador');

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
        Schema::dropIfExists('operador');
    }
}
