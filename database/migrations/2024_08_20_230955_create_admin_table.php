<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->unsignedBigInteger('cod_ips');

            $table->foreign('cod_ips')->references('cod_ips')->on('ips');

            $table->string('nom_admin');
            $table->string('ape_admin');
            $table->string('documento_admin')->unique();
            $table->string('email_admin')->unique();
            $table->integer('tel_admin')->unique();

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
        Schema::dropIfExists('admin');
    }
}
