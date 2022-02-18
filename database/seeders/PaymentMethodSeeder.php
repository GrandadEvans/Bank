<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
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
                'abbreviation' => '---',
                'method' => 'Unknown'
            ],
            [
                'abbreviation' => 'CHG',
                'method' => 'Bank Charge'
            ],
            [
                'abbreviation' => 'BP',
                'method' => 'Benefit Payment'
            ],
            [
                'abbreviation' => 'BGC',
                'method' => 'Bank Giro Credit'
            ],
            [
                'abbreviation' => 'CSH',
                'method' => 'CSH'
            ],
            [
                'abbreviation' => 'CPT',
                'method' => 'Cashpoint'
            ],
            [
                'abbreviation' => 'CHQ',
                'method' => 'Cheque'
            ],
            [
                'abbreviation' => 'DEB',
                'method' => 'Debit Card'
            ],
            [
                'abbreviation' => 'DEP',
                'method' => 'Deposit'
            ],
            [
                'abbreviation' => 'DD',
                'method' => 'Direct Debit'
            ],
            [
                'abbreviation' => 'FPI',
                'method' => 'Fast Payment In'
            ],
            [
                'abbreviation' => 'FPO',
                'method' => 'Fast Payment Out'
            ],
            [
                'abbreviation' => 'FEE',
                'method' => 'Exchange Fee'
            ],
            [
                'abbreviation' => 'PAY',
                'method' => 'Payment'
            ],
            [
                'abbreviation' => 'SO',
                'method' => 'Standing Order'
            ],
            [
                'abbreviation' => 'TFR',
                'method' => 'Transfer'
            ],
        ];

        DB::table('payment_methods')->insert($values);
    }
}
