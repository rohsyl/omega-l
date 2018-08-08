<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*INSERT INTO `om_group_right` VALUES (1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(10,3),(11,3),(12,3),(13,3),(14,2),(14,3),(15,2),(15,3),(16,2),(16,3),(17,2),(17,3),(18,2),(18,3),(19,3),(20,3),(21,2),(21,3),(22,3),(23,3),(24,2),(24,3),(25,2),(25,3),(26,2),(26,3),(27,2),(27,3),(28,3),(29,2),(29,3),(30,3),(31,2),(31,3);
*/


        $groups = [
            [1,'public','This group can see the frontend of this website'],
            [2,'user','This group can manage the page part, the apparence part and the settings part in the backend of this website'],
            [3,'administrator','This group can do everythings'],
        ];

        foreach($groups as $group){
            DB::table('groups')->insert([
                'id' => $group[0],
                'name' => $group[1],
                'description' => $group[2],
                'isEnabled' => true,
                'isDeleted' => false,
                'isSystem' => true
            ]);
        }


        $groupRights = [
            [1,3],
            [2,3],
            [3,3],
            [4,3],
            [5,3],
            [6,3],
            [7,3],
            [8,3],
            [9,3],
            [10,3],
            [11,3],
            [12,3],
            [13,3],
            [14,2],
            [14,3],
            [15,2],
            [15,3],
            [16,2],
            [16,3],
            [17,2],
            [17,3],
            [18,2],
            [18,3],
            [19,3],
            [20,3],
            [21,2],
            [21,3],
            [22,3],
            [23,3],
            [24,2],
            [24,3],
            [25,2],
            [25,3],
            [26,2],
            [26,3],
            [27,2],
            [27,3],
            [28,3],
            [29,2],
            [29,3],
            [30,3],
            [31,2],
            [31,3]
        ];

        foreach($groupRights as $gr){

            DB::table('grouprights')->insert([
                'fkRight' => $gr[0],
                'fkGroup' => $gr[1]
            ]);

        }

    }
}
