<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediametasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mediametas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang', 2);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->integer('fkMedia')->unsigned();
            $table->foreign('fkMedia')
                ->references('id')->on('medias')
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
        Schema::dropIfExists('mediametas');
    }
}
