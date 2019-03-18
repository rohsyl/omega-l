<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertUsergroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // insert every user in the admin group by default
        $users = \Omega\Models\User::all();
        $group = \Omega\Models\Group::where('name', 'administrator')->first();

        foreach($users as $user){
            if(!DB::table('usergroups')
                ->where('fkUser', $user->id)
                ->where('fkGroup', $group->id)
                ->exists())
            $user->groups()->attach($group->id);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
