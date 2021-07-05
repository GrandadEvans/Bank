<?php

namespace Database\Seeders;

use Bank\Models\Tag;
use Bank\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaymentMethodSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProviderSeeder::class);
        $this->call(TransactionsSeeder::class);
//        $this->call(RegularSeeder::class);
        $this->call(TagSeeder::class);
    }
}
