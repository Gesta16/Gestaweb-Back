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
        $table->integer('cod_seguimiento')->primary(); // Clave primaria
        
        // Claves foráneas
        $table->integer('cod_riesgo'); // FK a la tabla de riesgos
        $table->unsignedBigInteger('cod_controles'); // FK a la tabla de controles
        $table->unsignedBigInteger('cod_diagnostico'); // FK a la tabla de diagnóstico
        $table->unsignedBigInteger('cod_medicion'); // FK a la tabla de forma de medición
        
        // Campos adicionales
        $table->date('fec_consulta'); // Fecha de consulta
        $table->integer('edad_gestacional'); // Edad gestacional al momento de la consulta
        $table->decimal('alt_uterina', 5, 2); // Altura uterina en cm
        $table->integer('trim_gestacional'); // Trimestre gestacional actual
        $table->decimal('peso', 5, 2); // Peso en kg
        $table->decimal('talla', 5, 2); // Talla en metros
        $table->decimal('imc', 5, 2); // Índice de Masa Corporal (IMC)
        $table->decimal('ten_arts', 5, 2); // Tensión arterial sistólica
        $table->decimal('ten_artd', 5, 2); // Tensión arterial diastólica


        // Definir las relaciones
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
