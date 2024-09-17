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
            $table->integer('cod_doslaboratorio')->primary();

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

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
