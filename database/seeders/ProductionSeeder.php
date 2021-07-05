<?php

namespace Database\Seeders;


use Bank\Models\User;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaymentMethodSeeder::class);
        $default = new User([
            'name' => 'John Evans',
            'email' => 'john@grandadevans.com',
            'password' => env('default_user_password')
        ]);
        $default->save();

    }
}
