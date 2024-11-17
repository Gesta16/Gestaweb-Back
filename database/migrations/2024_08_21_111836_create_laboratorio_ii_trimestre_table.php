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

            $table->string('pru_vih');
            $table->date('fec_vih');
            $table->string('pru_sifilis');
            $table->date('fec_sifilis');
            $table->string('pru_oral');
            $table->string('pru_uno');
            $table->string('pru_dos');
            $table->date('fec_prueba');
            $table->string('rep_citologia');
            $table->date('fec_citologia');
            $table->string('ig_toxoplasma');
            $table->date('fec_toxoplasma');
            $table->string('pru_avidez');
            $table->date('fec_avidez');
            $table->string('tox_laboratorio');
            $table->date('fec_toxoplasmosis');
            $table->string('hem_gruesa');
            $table->date('fec_hemoparasito');
            $table->string('coo_cualitativo');
            $table->date('fec_coombs');
            $table->date('fec_ecografia');
            $table->decimal('eda_gestacional', 8, 2);
            $table->string('rie_biopsicosocial');
            $table->boolean('reali_prueb_rapi_vih');//Realizó la prueba rápida VIH
            $table->boolean('real_prueb_trep_rap_sifilis');//Realizó la prueba treponémica rápida sífilis
            $table->boolean('reali_citologia');//Realizó la citología
            $table->boolean('reali_prueb_avidez_ig_g');//Realizó la prueba de avidez IG-G
            $table->boolean('reali_prueb_toxoplasmosis_ig_a');//Realizó la prueba de toxoplasmosis IG-A
            $table->boolean('reali_prueb_hemoparasito');//Realizó la prueba Hemoparásito - gota gruesa
            $table->boolean('reali_prueb_coombis_indi_cuanti');//Realizó la prueba Coombis indirecto cuantitativo
            $table->boolean('reali_eco_obste_detalle_anato');//Realizó la ecografía obtétrica detalle anatómico
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
