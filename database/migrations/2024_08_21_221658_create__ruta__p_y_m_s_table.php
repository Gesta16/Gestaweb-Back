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
        $table->integer('cod_ruta')->primary(); // Clave primaria

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
