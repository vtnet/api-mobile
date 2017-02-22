<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MobileRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_request', function(Blueprint $table)
        {
            $table->increments('id');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->string('origem');
            $table->string('destino');
            $table->string('localizacao');
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
        Schema::drop('mobile_request');
    }
}
