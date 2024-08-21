<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ips', function (Blueprint $table) {
            $table->integer('cod_ips')->primary();
            $table->integer('cod_regimen');

            $table->foreign('cod_regimen')->references('cod_regimen')->on('regimen');

            $table->string('nom_ips');
            $table->string('dir_ips');
            $table->integer('tel_ips');

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
        Schema::dropIfExists('ips');
    }
}
