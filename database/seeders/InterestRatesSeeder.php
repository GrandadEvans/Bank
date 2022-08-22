<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [
                'date' => '2008-02-07',
                'rate' => 5.25
            ],
            [
                'date' => '2008-04-10',
                'rate' => 5.00
            ],
            [
                'date' => '2008-10-08',
                'rate' => 4.50
            ],
            [
                'date' => '2008-11-06',
                'rate' => 3.00
            ],
            [
                'date' => '2008-12-04',
                'rate' => 2.00
            ],
            [
                'date' => '2009-01-08',
                'rate' => 1.50
            ],
            [
                'date' => '2009-02-05',
                'rate' => 1.00
            ],
            [
                'date' => '2009-03-05',
                'rate' => 0.50
            ],
            [
                'date' => '2016-08-04',
                'rate' => 0.25
            ],
            [
                'date' => '2017-11-02',
                'rate' => 0.50
            ],
            [
                'date' => '2018-08-02',
                'rate' => 0.75
            ],
            [
                'date' => '2020-03-11',
                'rate' => 0.25
            ],
            [
                'date' => '2020-03-19',
                'rate' => 0.10
            ],
            [
                'date' => '2021-12-16',
                'rate' => 0.25
            ],
            [
                'date' => '2022-02-03',
                'rate' => 0.50
            ],
            [
                'date' => '2022-03-17',
                'rate' => 0.75
            ],
            [
                'date' => '2022-05-05',
                'rate' => 1.00
            ],
            [
                'date' => '2022-06-16',
                'rate' => 1.25
            ],
            [
                'date' => '2022-08-04',
                'rate' => 1.75
            ]
         ];

        DB::table('interest_rates')->insert($values);
    }
}
