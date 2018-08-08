<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('subtitle');
            $table->boolean('showName');
            $table->boolean('showSubtitle');
            $table->text('keyWords');
            $table->string('model');
            $table->string('cssTheme');
            $table->integer('order');
            $table->boolean('isEnabled');
            $table->string('lang', 2);

            $table->integer('fkPageParent')->unsigned();
            $table->integer('fkUser')->unsigned()->nullable();
            $table->integer('fkMenu')->unsigned()->nullable();

            $table->foreign('fkPageParent')
                ->references('id')->on('pages')
                ->onDelete('cascade');

            $table->foreign('fkUser')
                ->references('id')->on('users')
                ->onDelete('set null');

            $table->foreign('fkMenu')
                ->references('id')->on('menus')
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
        Schema::dropIfExists('pages');
    }
}
