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
            $table->string('pru_vih')->nullable();
            $table->date('fec_vih')->nullable();
            
            // Prueba treponémica rápida para sífilis
            $table->string('pru_sifilis')->nullable();
            $table->date('fec_sifilis')->nullable();
            
            // IG-M toxoplasma
            $table->string('ig_toxoplasma')->nullable();
            $table->date('fec_toxoplasma')->nullable();
            
            // Cultivo rectal y vaginal
            $table->string('cul_rectal')->nullable();
            $table->date('fec_rectal')->nullable();
            
            // Fecha perfil biofísico
            $table->date('fec_biofisico')->nullable();
            
            // Edad gestacional al momento de la ecografía de perfil
            $table->integer('edad_gestacional');
            
            // Riesgo biopsicosocial escala de Herrera y Hurtado
            $table->string('rie_biopsicosocial');
            $table->boolean('reali_prueb_rapi_vih');//Realizó la prueba rápida VIH
            $table->boolean('reali_prueb_trepo_rapi_sifilis');//Realizó la prueba treponémica rápida para sífilis
            $table->boolean('reali_prueb_igm_toxoplasma');//Realizó la prueba IG-M toxoplasma
            $table->boolean('reali_prueb_culti_rect_vagi');//Realizó la prueba de cultivo rectal y vaginal
            $table->boolean('reali_prueb_perfil_biofisico');//Realizó la prueba de Perfil biofísico

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
