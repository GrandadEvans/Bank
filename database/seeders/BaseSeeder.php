<?php

namespace Database\Seeders;

use Bank\Models\Provider;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaymentMethodSeeder::class);

        Provider::create([
            'name' => 'N/A',
            'payment_method_id' => 1
        ]);

    }
}
