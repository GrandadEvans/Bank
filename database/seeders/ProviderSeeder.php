<?php

namespace Database\Seeders;


use Bank\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::factory()->create([
            'name' => 'N/A',
            'payment_method_id' => 7
        ]);
        Provider::factory()->count(9)->create();
    }
}
