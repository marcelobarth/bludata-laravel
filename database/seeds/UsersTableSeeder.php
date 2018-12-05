<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
    		'name' => 'Bludata',
    		'email' => 'marcelinhobarth@hotmail.com',
    		'password' => bcrypt('123'),
    	]);
    }
}
