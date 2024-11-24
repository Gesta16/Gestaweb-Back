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

        // Clave foránea
        $table->unsignedBigInteger('id_operador');
        $table->foreign('id_operador')->references('id_operador')->on('operador');

        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        $table->unsignedBigInteger('cod_sesiones'); 
        $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

        
        // Campos adicionales
        $table->date('fec_nutricion')->nullable();       
        $table->date('fec_ginecologia')->nullable();     
        $table->date('fec_psicologia')->nullable();      
        $table->date('fec_odontologia')->nullable();     
        $table->string('ina_seguimiento');   
        $table->string('cau_inasistencia')->nullable();  
        $table->boolean('asistio_nutricionista');
        $table->boolean('asistio_ginecologia');
        $table->boolean('asistio_psicologia');
        $table->boolean('asistio_odontologia');

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
