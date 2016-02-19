<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            'name'=>'admin',
//            'email'=>'admin@site.ru',
//            'password'=>bcrypt('peqof0xX'),
//        ]);
        \App\User::create([
            'name'=>'admin',
            'email'=>'admin@site.ru',
            'password'=>bcrypt('peqof0xX'),
        ]);
    }
}
