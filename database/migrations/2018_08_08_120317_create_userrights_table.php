<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserrightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userrights', function (Blueprint $table) {

            $table->integer('fkRight')->unsigned();
            $table->integer('fkUser')->unsigned();

            $table->foreign('fkRight')
                ->references('id')->on('rights')
                ->onDelete('cascade');

            $table->foreign('fkUser')
                ->references('id')->on('users')
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
        Schema::dropIfExists('userrights');
    }
}
