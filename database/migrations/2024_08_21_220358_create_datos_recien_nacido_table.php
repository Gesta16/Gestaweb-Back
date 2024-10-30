<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosRecienNacidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('datos_recien_nacido', function (Blueprint $table) {
        $table->id('cod_recien'); // Clave primaria
        
        $table->unsignedBigInteger('id_operador');
        $table->foreign('id_operador')->references('id_operador')->on('operador');

        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        $table->foreignId('proceso_gestativo_id')->constrained('procesos_gestativos');

        
        // Campos adicionales
        $table->string('tip_embarazo');           
        $table->integer('num_nacido');          
        $table->string('sexo');                 
        $table->integer('peso');                  
        $table->integer('talla');                
        $table->string('pla_canguro');            
        $table->string('ips_canguro')->nullable();
        
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_recien_nacido');
    }
}
