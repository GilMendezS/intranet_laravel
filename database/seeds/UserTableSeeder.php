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
        \App\User::create([
            'name' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin'),
        ]);
        \App\User::create([
            'name' => 'Normal',
            'lastname' => 'Normal',
            'email' => 'normal@mail.com',
            'password' => bcrypt('normal'),
        ]);
    }
}
