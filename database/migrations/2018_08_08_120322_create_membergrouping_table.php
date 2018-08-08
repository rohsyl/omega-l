<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembergroupingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membergrouping', function (Blueprint $table) {

            $table->integer('fkMember')->unsigned();
            $table->integer('fkMemberGroup')->unsigned();

            $table->foreign('fkMember')
                ->references('id')->on('members')
                ->onDelete('cascade');

            $table->foreign('fkMemberGroup')
                ->references('id')->on('membergroups')
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
        Schema::dropIfExists('membergrouping');
    }
}
