<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rights = [
            [1,'user_read','Can read all data about users'],
            [2,'user_add','Can add a new user'],
            [3,'user_update_data','Can update data for users'],
            [4,'user_update_rights','Can update user\'s rights'],
            [5,'user_update_group','Can update group for users'],
            [6,'user_delete','Can delete an user'],
            [7,'user_disable','Can disable or enable an user'],
            [8,'user_update_himself','Can update himself'],
            [9,'group_read','Can read all data about groups'],
            [10,'group_add','Can add a new group'],
            [11,'group_update','Can update an existing groups'],
            [12,'group_delete','Can delete an existing groups'],
            [13,'group_disable','Can disable or enable a groups'],
            [14,'page_read','Can read all data about pages'],
            [15,'page_add','Can add a new page'],
            [16,'page_update','Can update an existing page'],
            [17,'page_delete','Can delete an existing page'],
            [18,'page_disable','Can disable or enable a page'],
            [19,'setting_general','Can manage generals settings'],
            [20,'setting_mysql','Can manage MySQL login informations'],
            [21,'setting_template','Can manage templates'],
            [22,'file_editor_read','Can read files'],
            [23,'file_editor_write','Can write files'],
            [24,'menu_read','Can read all data about menus'],
            [25,'menu_add','Can add a new menu'],
            [26,'menu_update','Can update an existing menu'],
            [27,'menu_delete','Can delete an existing menu'],
            [28,'super_admin','If a user is super_admin, he can give super_admin and any others rights to any user. A super_admin can do every things. Others users can\'t do any action to a super_admin. Can delete himself if he isn\'t the last super_admin. Can disable himself if he isn\'t the last super_admin'],
            [29,'can_login','Can log into the back-end of Omega'],
            [30,'is_developper','The user is a developper'],
            [31,'can_access_media_library','Can use the Media Library']
        ];

        foreach($rights as $right){

            DB::table('rights')->insert([
                'id' => $right[0],
                'name' => $right[1],
                'description' => $right[2]
            ]);

        }
    }
}
