<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $securityTypes = [
            [1, 'bypassword', 'By password'],
            [2, 'bymember', 'By member'],
            [3, 'none', 'None']
        ];

        foreach($securityTypes as $type){

            DB::table('page_security_types')->insert([
                'id' => $type[0],
                'name' => $type[1],
                'title' => $type[2]
            ]);

        }
    }
}
