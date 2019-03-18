<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRights extends Migration
{

    /**
     * @var array
     */
    private $rights = [
        ['user_read','Can read all data about users'],
        ['user_add','Can add a new user'],

        ['user_update_himself','Can update himself'],
        ['user_update_data','Can update data for users'],
        ['user_update_rights','Can update user\'s rights'],
        ['user_update_group','Can update group for users'],

        ['user_delete','Can delete an user'],
        ['user_disable','Can disable or enable an user'],

        ['group_read','Can read all data about groups'],
        ['group_add','Can add a new group'],
        ['group_update','Can update an existing groups'],
        ['group_delete','Can delete an existing groups'],
        ['group_disable','Can disable or enable a groups'],

        ['page_read','Can read all data about pages'],
        ['page_add','Can add a new page'],
        ['page_update','Can update an existing page'],
        ['page_delete','Can delete an existing page'],
        ['page_disable','Can disable or enable a page'],

        ['setting_general','Can manage generals settings'],
        ['setting_flang','Can manage front-end language settings'],
        ['setting_seo','Can manage front-end language settings'],
        ['setting_member','Can manage member settings'],
        ['setting_advanced','Can manage advanced settings'],

        ['menu_read','Can read all data about menus'],
        ['menu_add','Can add a new menu'],
        ['menu_update','Can update an existing menu'],
        ['menu_delete','Can delete an existing menu'],

        ['theme_read','Can see themes'],
        ['theme_install','Can install and uninstall theme'],
        ['theme_delete','Can delete theme'],
        ['theme_use','Can set the theme in use'],
        ['theme_publish','Can publish theme assets'],
        ['theme_modulearea','Can manage theme modulearea'],


        ['member_read','Can see members'],
        ['member_add','Can add new member'],
        ['member_update','Can update member'],
        ['member_delete','Can delete member'],
        ['membergroup_read','Can see membergroups'],
        ['membergroup_add','Can add new membergroup'],
        ['membergroup_update','Can update membergroups'],
        ['membergroup_delete','Can delete membergroups'],

        ['plugin_install','Can install and uninstall plugins'],
        ['plugin_read','Can see plugins'],
        ['plugin_publish','Can publish plugin\'s assets'],

        ['super_admin','If a user is super_admin, he can give super_admin and any others rights to any user. A super_admin can do every things. Others users can\'t do any action to a super_admin. Can delete himself if he isn\'t the last super_admin. Can disable himself if he isn\'t the last super_admin'],

        ['is_developper','The user is a developper'],

        ['can_access_media_library','Can use the Media Library']
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // empty the rights table
        DB::table('rights')->delete();

        // and fill it with the new rights
        foreach($this->rights as $right){
            DB::statement('CALL om_AddRight(:name, :description);', [
                $right[0],
                $right[1]
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
        foreach($this->rights as $right){
            DB::table('rights')
                ->where('name', $right[0])
                ->delete();
        }
    }
}
