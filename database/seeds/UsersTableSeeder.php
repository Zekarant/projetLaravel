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
        User::create([
            'name' => 'CHOMEL Colin',
            'email' => 'colin42660@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('admin'),
            'settings' => '{"pagination": 8, "adult": true}',
            'email_verified_at' => Carbon::now(),
        ]);

        User::create([
            'name' => "LEFEBVRE Laura",
            'email' => "lauralefebvre@mail.com",
            'settings' => '{"pagination": 8, "adult": true}',
            'role' => "user",
            'password' => bcrypt('user'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
