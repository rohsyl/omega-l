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
            $table->string('subtitle')->nullable();
            $table->boolean('showName')->default(true);
            $table->boolean('showSubtitle')->default(true);
            $table->text('keyWords')->nullable();
            $table->string('model')->nullable();
            $table->string('cssTheme')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('isEnabled')->default(true);
            $table->string('lang', 2)->nullable();

            $table->integer('fkPageParent')->unsigned()->nullable();
            $table->integer('fkUser')->unsigned()->nullable();
            $table->integer('fkMenu')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

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
