<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormentriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formentries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->longText('param');
            $table->string('title');
            $table->text('description');
            $table->boolean('isModule');
            $table->boolean('isComponent');

            $table->integer('fkForm')->unsigned();

            $table->foreign('fkForm')
                ->references('id')->on('forms')
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
        Schema::dropIfExists('formentries');
    }
}
