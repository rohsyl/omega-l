<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LangsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('langs')->insert([
            'slug' => 'en',
            'name' => 'English',
            'isEnabled' => true,
            'fkMediaFlag' => null
        ]);
    }
}
