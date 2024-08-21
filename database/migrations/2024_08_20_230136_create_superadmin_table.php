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
            $table->integer('id_superadmin')->primary();
            $table->integer('cod_ips');

            $table->foreign('cod_ips')->references('cod_ips')->on('ips');

            $table->string('nom_superadmin');
            $table->string('ape_superadmin');
            $table->string('usu_superadmin');
            $table->string('cont_superadmin');
            $table->string('email_superadmin')->unique();
            $table->integer('tel_superadmin')->unique();

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
