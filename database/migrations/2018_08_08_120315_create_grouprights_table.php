<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrouprightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grouprights', function (Blueprint $table) {

            $table->integer('fkGroup')->unsigned();
            $table->integer('fkRight')->unsigned();

            $table->foreign('fkGroup')
                ->references('id')->on('groups')
                ->onDelete('cascade');

            $table->foreign('fkRight')
                ->references('id')->on('rights')
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
        Schema::dropIfExists('grouprights');
    }
}
