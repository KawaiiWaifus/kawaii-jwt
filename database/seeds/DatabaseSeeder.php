<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \Model::unguard();

        // $this->call(UserTableSeeder::class);
        DB::table('users')->delete();

        $users = array(
            ['name' => 'test', 'email' => 'test@test.com', 'password' => bcrypt('123456')],
            ['name' => 'admin', 'email' => 'admin@admin.com', 'password' => bcrypt('123456')],
            ['name' => 'administrador', 'email' => 'administrador@administrador.com', 'password' => bcrypt('123456')],
            ['name' => 'administrator', 'email' => 'administrator@administrator.com', 'password' => bcrypt('123456')],
        );

        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }

        // \Model::reguard();
    }
}
