<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigsTableSeeder::class);
        $this->call(MediasTableSeeder::class);
        $this->call(SecurityTypesTableSeeder::class);
        $this->call(LangsTableSeeder::class);
        $this->call(MembergroupsTableSeeder::class);
    }
}
