<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagelangrelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_lang_rels', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fkPage1')->unsigned();
            $table->integer('fkPage2')->unsigned();

            $table->foreign('fkPage1')
                ->references('id')->on('pages')
                ->onDelete('cascade');
            $table->foreign('fkPage2')
                ->references('id')->on('pages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_lang_rels');
    }
}
