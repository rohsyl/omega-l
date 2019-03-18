<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertGroups extends Migration
{

    private $groups = [
        ['public','This group can see the frontend of this website'],
        ['user','This group can manage the page part, the apparence part and the settings part in the backend of this website'],
        ['administrator','This group can do everythings'],
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('groups')->where('name', 'public')->delete();
        DB::table('groups')->where('name', 'user')->delete();
        DB::table('groups')->where('name', 'administrator')->delete();

        // and fill it with the new rights
        foreach($this->groups as $group){
            DB::table('groups')->insert([
                'name' => $group[0],
                'description' => $group[1],
                'isEnabled' => true,
                'isSystem' => true
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
