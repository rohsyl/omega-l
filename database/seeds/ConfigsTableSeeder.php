<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            ['om_site_title', 'OmegaCMS'],
            ['om_site_slogan', ''],
            ['om_lang', 'en'],
            ['om_home_page_id', null],
            ['om_web_adress', ''],
            ['om_default_front_langauge', 'en'],
            ['om_enable_front_langauge', false],
            ['version', '1'],
        ];

        foreach ($configs as $config){
            DB::table('configs')->insert([
                'key' => $config[0],
                'value' => $config[1],
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
    }
}
