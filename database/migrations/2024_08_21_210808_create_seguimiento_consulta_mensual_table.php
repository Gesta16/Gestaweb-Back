<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientoConsultaMensualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('seguimiento_consulta_mensual', function (Blueprint $table) {
        $table->id('cod_seguimiento'); 


        // Claves foráneas
        $table->unsignedBigInteger('id_operador');
        $table->foreign('id_operador')->references('id_operador')->on('operador');

        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        $table->unsignedBigInteger('cod_riesgo'); 
        $table->unsignedBigInteger('cod_controles'); 
        $table->unsignedBigInteger('cod_diagnostico'); 
        $table->unsignedBigInteger('cod_medicion'); 
        
        $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

        // Campos adicionales
        $table->date('fec_consulta'); 
        $table->integer('edad_gestacional'); 
        $table->decimal('alt_uterina', 5, 2); 
        $table->integer('trim_gestacional'); 
        $table->decimal('peso', 5, 2); 
        $table->decimal('talla', 5, 2); 
        $table->decimal('imc', 5, 2); 
        $table->decimal('ten_arts', 5, 2); 
        $table->decimal('ten_artd', 5, 2); 
        $table->timestamp('created_at')->useCurrent();



        $table->foreign('cod_riesgo')->references('cod_riesgo')->on('riesgo'); // Asegúrate de que la tabla y la columna existan
        $table->foreign('cod_controles')->references('cod_controles')->on('numero_controles'); // Asegúrate de que la tabla y la columna existan
        $table->foreign('cod_diagnostico')->references('cod_diagnostico')->on('diagnostico_nutricional_mes'); // Asegúrate de que la tabla y la columna existan
        $table->foreign('cod_medicion')->references('cod_medicion')->on('forma_medicion_edad_gestacional'); // Asegúrate de que la tabla y la columna existan
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimiento_consulta_mensual');
    }
}
