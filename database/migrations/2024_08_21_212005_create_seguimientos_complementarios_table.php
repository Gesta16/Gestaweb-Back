<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientosComplementariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('seguimientos_complementarios', function (Blueprint $table) {
        $table->id('cod_segcomplementario'); // Clave primaria

        $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        
        // Clave foránea
        $table->unsignedBigInteger('cod_sesiones'); // FK a la tabla de sesiones
        
        // Campos adicionales
        $table->date('fec_nutricion');       // Fecha de valoración de nutrición
        $table->date('fec_ginecologia');     // Fecha de valoración de ginecología
        $table->date('fec_psicologia');      // Fecha de valoración de psicología
        $table->date('fec_odontologia');     // Fecha de valoración de odontología
        $table->string('ina_seguimiento');   // Inasistente (si, no)
        $table->string('cau_inasistencia');  // Causal de inasistencia

        // Definir la relación
        $table->foreign('cod_sesiones')->references('cod_sesiones')->on('num_sesiones_curso_paternidad_maternidad');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimientos_complementarios');
    }
}
