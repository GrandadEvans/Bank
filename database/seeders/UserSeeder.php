<?php

namespace Database\Seeders;


use Bank\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        User::create([
//            'email' => 'john@grandadevans.com',
//            'password' => bcrypt(env('default_user_password')),
//            'name' => 'John Evans'
//        ]);

        User::factory()->count(10)->create();
    }
}
