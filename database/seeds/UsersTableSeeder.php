<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $androidUser = array(
        	'email' => 'android@moum',
        	'password' => bcrypt('123456'),
        	'tel' => 'android@moum'
        );
        $iosUser = array(
        	'email' => 'ios@moum',
        	'password' => bcrypt('123456'),
        	'tel' => 'ios@moum'
        );
        $phpUser = array(
        	'email' => 'php@moum',
        	'password' => bcrypt('123456'), 
        	'tel' => 'php@moum'
        );

        DB::table('users')->insert([$androidUser, $iosUser, $phpUser]);
    }
}
