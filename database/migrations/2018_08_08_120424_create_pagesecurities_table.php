<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesecuritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagesecurities', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fkType')->unsigned();
            $table->integer('fkPage')->unsigned();
            $table->longText('data');

            $table->foreign('fkType')
                ->references('id')->on('pagesecuritytypes')
                ->onDelete('cascade');

            $table->foreign('fkPage')
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
        Schema::dropIfExists('pagesecurities');
    }
}
