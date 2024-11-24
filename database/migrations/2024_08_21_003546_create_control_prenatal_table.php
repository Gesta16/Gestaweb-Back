<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlPrenatalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_prenatal', function (Blueprint $table) {
            $table->id('cod_control');

            $table->unsignedBigInteger('id_operador');
            $table->foreign('id_operador')->references('id_operador')->on('operador');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');

            $table->unsignedBigInteger('cod_fracaso')->nullable();
            $table->foreign('cod_fracaso')->references('cod_fracaso')->on('metodo_fracaso');

            $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

            $table->decimal('edad_gestacional', 4, 1);
            $table->string('trim_ingreso');
            $table->date('fec_mestruacion');
            $table->date('fec_parto');
            $table->boolean('emb_planeado');
            $table->boolean('fec_anticonceptivo');
            $table->date('fec_consulta')->nullable();
            $table->date('fec_control')->nullable();
            $table->string('ries_reproductivo');
            $table->date('fac_asesoria');
            $table->boolean('usu_solicito');
            $table->date('fec_terminacion')->nullable();
            $table->boolean('per_intergenesico');
            $table->boolean('recibio_atencion_preconcep'); //Recibió atención preconcepcional
            $table->boolean('asis_consul_control_precon'); //Asistió a la consulta de control atención preconcepcional
            $table->boolean('asis_asesoria_ive')->nullable();//Asistió a la asesoría IVE
            $table->boolean('tuvo_embarazos_antes');//Ha tenido algún embarazo anterior
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
        Schema::dropIfExists('control_prenatal');
    }
}
