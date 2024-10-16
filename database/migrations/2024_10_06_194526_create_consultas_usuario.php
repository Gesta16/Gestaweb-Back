<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas_usuario', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_usuario');
            $table->date('fecha');
            $table->string('nombre_consulta');
            
            // Establecer el índice en id_usuario
            $table->index('id_usuario', 'idx_id_usuario');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultas_usuario');
    }
}
