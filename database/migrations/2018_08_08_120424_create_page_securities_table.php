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
        Schema::create('page_securities', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fkType')->unsigned();
            $table->integer('fkPage')->unsigned();
            $table->longText('data')->nullable();

            $table->foreign('fkType')
                ->references('id')->on('page_security_types')
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
        Schema::dropIfExists('page_securities');
    }
}
