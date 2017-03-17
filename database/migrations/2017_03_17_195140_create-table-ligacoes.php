<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLigacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('telefones_id')->unsigned();
            $table->foreign('telefones_id')->references('id')->on('telefones');

            $table->string('datatime',25);
            $table->string('destino',60);
            $table->integer('qtd');
            $table->string('tipo',45);
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
        Schema::drop('ligacoes');
    }
}
