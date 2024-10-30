<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioIiiTrimestreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio_iii_trimestre', function (Blueprint $table) {
            $table->id('cod_treslaboratorio'); // Primary Key
            
            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
            
            $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');


            // Hemograma
            $table->string('hemograma');
            $table->date('fec_hemograma');
            
            // Prueba rápida VIH
            $table->string('pru_vih');
            $table->date('fec_vih');
            
            // Prueba treponémica rápida para sífilis
            $table->string('pru_sifilis');
            $table->date('fec_sifilis');
            
            // IG-M toxoplasma
            $table->string('ig_toxoplasma');
            $table->date('fec_toxoplasma');
            
            // Cultivo rectal y vaginal
            $table->string('cul_rectal');
            $table->date('fec_rectal');
            
            // Fecha perfil biofísico
            $table->date('fec_biofisico');
            
            // Edad gestacional al momento de la ecografía de perfil
            $table->integer('edad_gestacional');
            
            // Riesgo biopsicosocial escala de Herrera y Hurtado
            $table->string('rie_biopsicosocial');

            $table->timestamp('created_at')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratorio_iii_trimestre');
    }
}
