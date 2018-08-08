<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('path');
            $table->longText('json');
            $table->boolean('isEnabled');
            $table->boolean('isMain');
            $table->string('lang', 2);

            $table->integer('fkMemberGroup')->unsigned()->nullable();

            $table->foreign('fkMemberGroup')
                ->references('id')->on('medias')
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
        Schema::dropIfExists('menus');
    }
}
