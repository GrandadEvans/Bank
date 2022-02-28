<?php

namespace Database\Seeders;


use Bank\Models\User;
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
//            'password' => bcrypt(env('DEFAULT_USER_PASSWORD')),
//            'name' => 'John Evans'
//        ]);

        User::factory()->count(10)->create();
    }
}
