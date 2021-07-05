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
        Provider::factory()->create([
            'name' => 'Halifax Bank',
            'regular_expressions' => '' .
"/halifax/i
/tmpp/i
/mortgage/i"
        ]);
        Provider::factory()->create([
            'name' => 'Some Protection Company',
            'regular_expressions' => '/protection/i'
        ]);
        Provider::factory()->count(19)->create();
    }
}
