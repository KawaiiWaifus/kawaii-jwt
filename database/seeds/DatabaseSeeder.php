<?php

use Illuminate\Database\Seeder;
use Api\V1\Models\App\User;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {


        $faker = Faker::create();
    	foreach (range(1,250) as $index) {
	        DB::table('users')->insert([
	            'name' => $faker->name,
	            'email' => $faker->email,
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10),
                'active' => 0,
	        ]);
        }

        // Loop through each user above and create the record for them in the database
      /*  foreach ($users as $user)
        {
            User::create($user);
        }
      */
    }
}
