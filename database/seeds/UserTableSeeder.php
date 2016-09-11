<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      		DB::table('users')->insert([
            'name' => 'Administrator',
			'username' => 'admin',
            'email' => 'rpirpag@gmx.at',
            'password' => Hash::make('secretpassword'),
			'adminaccess' => 1,
			]);
      		DB::table('users')->insert([
            'name' => 'Reinhard Pagitsch',
			'username' => 'rpirpag',
            'email' => 'rpirpag@gmx.at',
            'password' => Hash::make('4reinhard4'),
			'adminaccess' => 0,
			]);
	}
}
