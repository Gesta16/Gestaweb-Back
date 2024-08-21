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
            $table->integer('cod_opexusu');
            $table->integer('id_operador');
            $table->integer('id_usuario');

            $table->primary(['cod_opexusu', 'id_operador', 'id_usuario']);

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
