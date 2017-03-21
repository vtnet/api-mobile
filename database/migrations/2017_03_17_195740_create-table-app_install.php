<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAppInstall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_install', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('telefones_id')->unsigned();
            $table->foreign('telefones_id')->references('id')->on('telefones');
            $table->string('modelo', 100);
            $table->string('id_device', 150);
            $table->string('id_onesignal', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_install');
    }
}
