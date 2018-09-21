<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order');
            $table->boolean('isEnabled');

            $table->integer('fkModuleArea')->unsigned();
            $table->integer('fkModule')->unsigned();
            $table->integer('fkPage')->unsigned()->nullable();

            $table->foreign('fkModuleArea')
                ->references('id')->on('module_areas')
                ->onDelete('cascade');

            $table->foreign('fkModule')
                ->references('id')->on('modules')
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
        Schema::dropIfExists('positions');
    }
}
