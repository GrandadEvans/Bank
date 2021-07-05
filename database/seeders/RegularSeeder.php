<?php

namespace Database\Seeders;


use Bank\Models\Regular;
use Illuminate\Database\Seeder;

class RegularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Regular::factory()->count(20)->create();
    }
}
