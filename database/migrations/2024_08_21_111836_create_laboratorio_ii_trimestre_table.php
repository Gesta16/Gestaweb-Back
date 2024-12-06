<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioIiTrimestreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio_ii_trimestre', function (Blueprint $table) {
            $table->id('cod_doslaboratorio');

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
            
            $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

            $table->string('pru_vih')->nullable();
            $table->date('fec_vih')->nullable();
            $table->string('pru_sifilis')->nullable();
            $table->date('fec_sifilis')->nullable();
            $table->string('pru_oral')->nullable();
            $table->string('pru_uno')->nullable();
            $table->string('pru_dos')->nullable();
            $table->date('fec_prueba')->nullable();
            $table->string('rep_citologia')->nullable();
            $table->date('fec_citologia')->nullable();
            $table->string('ig_toxoplasma')->nullable();
            $table->date('fec_toxoplasma')->nullable();
            $table->string('pru_avidez')->nullable();
            $table->date('fec_avidez')->nullable();
            $table->string('tox_laboratorio')->nullable();
            $table->date('fec_toxoplasmosis')->nullable();
            $table->string('hem_gruesa')->nullable();
            $table->date('fec_hemoparasito')->nullable();
            $table->string('coo_cualitativo')->nullable();
            $table->date('fec_coombs')->nullable();
            $table->date('fec_ecografia')->nullable();
            $table->decimal('eda_gestacional', 8, 2)->nullable();
            $table->string('rie_biopsicosocial');
            $table->boolean('reali_prueb_rapi_vih');//Realizó la prueba rápida VIH
            $table->boolean('real_prueb_trep_rap_sifilis');//Realizó la prueba treponémica rápida sífilis
            $table->boolean('reali_citologia');//Realizó la citología
            $table->boolean('reali_prueb_avidez_ig_g');//Realizó la prueba de avidez IG-G
            $table->boolean('reali_prueb_toxoplasmosis_ig_a');//Realizó la prueba de toxoplasmosis IG-A
            $table->boolean('reali_prueb_hemoparasito');//Realizó la prueba Hemoparásito - gota gruesa
            $table->boolean('reali_prueb_coombis_indi_cuanti');//Realizó la prueba Coombis indirecto cuantitativo
            $table->boolean('reali_eco_obste_detalle_anato');//Realizó la ecografía obtétrica detalle anatómico
            $table->boolean('real_igm_toxoplasma');
            $table->boolean('real_prueb_oral');
            $table->boolean('real_prueb_oral_1');
            $table->boolean('real_prueb_oral_2');
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
        Schema::dropIfExists('laboratorio_ii_trimestre');
    }
}
