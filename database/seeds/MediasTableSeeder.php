<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medias')->insert([
            'id' => 1,
            'type' => 1,
            'fkParent' => null,
            'name' => 'ROOT',
            'title' => '',
            'description' => '',
            'ext' => '',
            'path' => '',

        ]);
    }
}
