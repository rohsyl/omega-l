<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembergroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $memberGroups = [
            [1, 'public'],
            [2, 'member']
        ];

        foreach($memberGroups as $group){

            DB::table('membergroups')->insert([
                'id' => $group[0],
                'name' => $group[1]
            ]);

        }
    }
}
