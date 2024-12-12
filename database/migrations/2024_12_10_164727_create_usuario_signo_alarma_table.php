<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioSignoAlarmaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_signo_alarma', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // Clave foránea para la tabla usuarios
            $table->unsignedBigInteger('signo_alarma_id'); // Clave foránea para la tabla signo_alarmas

            // Definir las relaciones
            $table->foreign('usuario_id')->references('id_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('signo_alarma_id')->references('id')->on('signo_alarmas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_signo_alarma');
    }
}
