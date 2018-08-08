<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('param');
            $table->boolean('isEnabled');
            $table->boolean('isComponent');
            $table->integer('order' );

            $table->integer('fkPlugin')->unsigned();
            $table->integer('fkPage')->unsigned()->nullable();

            $table->foreign('fkPlugin')
                ->references('id')->on('pages')
                ->onDelete('cascade');

            $table->foreign('fkPage')
                ->references('id')->on('pages')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
