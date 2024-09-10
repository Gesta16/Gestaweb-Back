<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperadminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('superadmin', function (Blueprint $table) {
            $table->id('id_superadmin');
            $table->string('nom_superadmin');
            $table->string('ape_superadmin');

            $table->unsignedBigInteger('cod_documento');
            $table->foreign('cod_documento')->references('cod_documento')->on('tipo_de_documento');
            
            $table->string('documento_superadmin')->unique();
            $table->string('email_superadmin')->unique();
            $table->integer('tel_superadmin');


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
        Schema::dropIfExists('superadmin');
    }
}
