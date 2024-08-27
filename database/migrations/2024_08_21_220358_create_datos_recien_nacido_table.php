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
        $table->integer('cod_recien')->primary(); // Clave primaria
        
        // Campos adicionales
        $table->string('tip_embarazo');           // Tipo de embarazo (único, múltiple)
        $table->integer('num_nacido');            // Número de recién nacido
        $table->string('sexo');                   // Sexo (Femenino, masculino)
        $table->integer('peso');                  // Peso al nacer en gramos
        $table->integer('talla');                 // Talla al nacer en cm
        $table->string('pla_canguro');            // Está en plan canguro (Si, No)
        $table->string('ips_canguro');            // IPS atención plan canguro
        
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
