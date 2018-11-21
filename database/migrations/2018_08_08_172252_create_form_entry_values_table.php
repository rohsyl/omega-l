<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormentryvaluesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_entry_values', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('value')->nullable();

            $table->integer('fkFormEntry')->unsigned();
            $table->integer('fkModule')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fkFormEntry')
                ->references('id')->on('form_entries')
                ->onDelete('cascade');

            $table->foreign('fkModule')
                ->references('id')->on('modules')
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
        Schema::dropIfExists('form_entry_values');
    }
}
