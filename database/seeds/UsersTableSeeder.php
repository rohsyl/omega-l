<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('users')->insert([
            'username' => 'root',
            'password' => Hash::make('pass'),
            'email' => 'syzin12@gmail.com',
            'fullname' => 'Sylvain Roh'
        ]);*/
    }
}
