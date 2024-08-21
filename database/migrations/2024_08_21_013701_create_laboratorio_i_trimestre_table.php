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
            $table->integer('cod_laboratorio')->primary();

            $table->integer('cod_opexusu');
            $table->foreign('cod_opexusu')->references('cod_opexusu')->on('operadorxusuario');

            $table->integer('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->integer('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->integer('cod_hemoclasifi');
            $table->foreign('cod_hemoclasifi')->references('cod_hemoclasifi')->on('hemoclasificacion');

            $table->integer('cod_antibiograma');
            $table->foreign('cod_antibiograma')->references('cod_antibiograma')->on('antibiograma');

            $table->date('fec_hemoclasificacion');
            $table->string('hem_laboratorio');
            $table->date('fec_hemograma');
            $table->integer('gli_laboratorio');
            $table->date('fec_glicemia');
            $table->string('ant_laboratorio');
            $table->date('fec_antigeno');
            $table->string('pru_vih');
            $table->date('fec_vih');
            $table->string('pru_sifilis');
            $table->date('fec_sifilis');
            $table->string('uro_laboratorio');
            $table->date('fec_urocultivo');
            $table->date('fec_antibiograma');
            $table->string('ig_rubeola');
            $table->date('fec_rubeola');
            $table->string('ig_toxoplasma');
            $table->date('fec_toxoplasma');
            $table->string('hem_gruesa');
            $table->date('fec_hemoparasito');
            $table->string('pru_antigenos');
            $table->date('fec_antigenos');
            $table->string('eli_recombinante');
            $table->date('fec_recombinante');
            $table->string('coo_cuantitativo');
            $table->date('fec_coombs');
            $table->date('fec_ecografia');
            $table->decimal('eda_gestacional', 8, 2);
            $table->string('rie_biopsicosocial');

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
