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
            $table->text('description')->nullable();
            $table->string('path')->nullable();
            $table->longText('json')->nullable();
            $table->boolean('isEnabled')->default(true);
            $table->boolean('isMain')->default(false);
            $table->string('lang', 2)->nullable();

            $table->integer('fkMemberGroup')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('fkMemberGroup')
                ->references('id')->on('membergroups')
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
