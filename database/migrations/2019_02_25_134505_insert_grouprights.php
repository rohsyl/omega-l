<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertGrouprights extends Migration
{
    private $grouprights = [
        'super_admin' => 'administrator',

        'user_read' => 'user',
        'user_update_himself' => 'user',
        'group_read' => 'user',
        'page_read' => 'user',
        'page_add' => 'user',
        'page_update' => 'user',
        'page_delete' => 'user',
        'page_disable' => 'user',
        'setting_general' => 'user',
        'setting_seo' => 'user',
        'menu_read' => 'user',
        'menu_add' => 'user',
        'menu_update' => 'user',
        'menu_delete' => 'user',
        'theme_read' => 'user',
        'theme_use' => 'user',
        'plugin_read' => 'user',
        'can_access_media_library' => 'user',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->grouprights as $right => $group){
            DB::statement('CALL om_AssignRightToGroup(:right, :group);', [
                $right,
                $group
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
