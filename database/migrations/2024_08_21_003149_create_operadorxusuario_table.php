<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperadorxusuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operadorxusuario', function (Blueprint $table) {
            $table->unsignedBigInteger('id_operador');
            $table->unsignedBigInteger('id_usuario');

            $table->primary(['id_operador', 'id_usuario']);

            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

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
        Schema::dropIfExists('operadorxusuario');
    }
}
