<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutaPYMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('_ruta__p_y_m_s', function (Blueprint $table) {
        $table->id('cod_ruta'); // Clave primaria

        $table->unsignedBigInteger('id_operador');
        $table->foreign('id_operador')->references('id_operador')->on('operador');

        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

        $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');


        // Campos adicionales
        $table->date('fec_bcg');               // Fecha de vacunación BCG
        $table->date('fec_hepatitis');         // Fecha de vacunación hepatitis
        $table->date('fec_seguimiento');       // Fecha de seguimiento a recién nacido
        $table->date('fec_entrega');           // Fecha de entrega de carnet
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_ruta__p_y_m_s');
    }
}
