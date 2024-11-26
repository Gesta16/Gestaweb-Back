<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioITrimestreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio_i_trimestre', function (Blueprint $table) {
            $table->id('cod_laboratorio');

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->unsignedBigInteger('cod_hemoclasifi');
            $table->foreign('cod_hemoclasifi')->references('cod_hemoclasifi')->on('hemoclasificacion');

            $table->unsignedBigInteger('cod_antibiograma');
            $table->foreign('cod_antibiograma')->references('cod_antibiograma')->on('antibiograma');

            $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

            $table->date('fec_hemoclasificacion');
            $table->string('hem_laboratorio');
            $table->date('fec_hemograma');
            $table->integer('gli_laboratorio');
            $table->date('fec_glicemia');
            $table->string('ant_laboratorio');
            $table->date('fec_antigeno');
            $table->string('pru_vih')->nullable();
            $table->date('fec_vih')->nullable();
            $table->string('pru_sifilis')->nullable();
            $table->date('fec_sifilis')->nullable();
            $table->string('uro_laboratorio')->nullable();
            $table->date('fec_urocultivo')->nullable();
            $table->date('fec_antibiograma')->nullable();
            $table->string('ig_rubeola');
            $table->date('fec_rubeola');
            $table->string('ig_toxoplasma');
            $table->date('fec_toxoplasma');
            $table->string('hem_gruesa');
            $table->date('fec_hemoparasito');
            $table->string('pru_antigenos')->nullable();
            $table->date('fec_antigenos')->nullable();
            $table->string('eli_recombinante')->nullable();
            $table->date('fec_recombinante')->nullable();
            $table->string('coo_cuantitativo')->nullable();
            $table->date('fec_coombs')->nullable();
            $table->date('fec_ecografia')->nullable();
            $table->decimal('eda_gestacional', 8, 2)->nullable();
            $table->string('rie_biopsicosocial');
            $table->boolean('real_prueb_rapi_vih');//Realizó la prueba rápida VIH
            $table->boolean('reali_prueb_trepo_rapid_sifilis');//Realizó la prueba treponémica rápida sífilis
            $table->boolean('realizo_urocultivo');
            $table->boolean('realizo_antibiograma');
            $table->boolean('real_prueb_eliza_anti_total');//Realizó la prueba de elisa antígenos totales
            $table->boolean('real_prueb_eliza_anti_recomb');//Realizó la prueba de elisa antígenos recombinante
            $table->boolean('real_prueb_coombis_indi_cuanti');//Realizó la prueba de Coombis indirecto cuantitativo
            $table->boolean('real_eco_obste_tamizaje');//Realizó la ecografía obstétrica tamizaje
            $table->timestamp('created_at')->useCurrent();


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
        Schema::dropIfExists('laboratorio_laboratorio_i_trimestre');
    }
}
