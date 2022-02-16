<?php

namespace Database\Seeders;

use Bank\Models\Provider;
use Bank\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::factory()->count(250)->create();
        $p1 = Provider::factory()->create();
        $p2 = Provider::factory()->create();
        $p3 = Provider::factory()->create();
        $p4 = Provider::factory()->create();
        $p5 = Provider::factory()->create();
        $p6 = Provider::factory()->create();
        $p7 = Provider::factory()->create();
        // Create Daily Transactions
//        $dailyTransactions = [];
        for ($i = 1; $i < 5; $i++) {
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p1->id,
                'entry' => 'Daily match',
                'date' => "2021-01-0{$i}",
                'amount' => 24.75
            ])->create();
//            $dailyTransactions[] = $transaction;
        }
//        $this->transactions[$transaction->entry] = [
//            'period' => 'day',
//            'transactions' => $dailyTransactions
//        ];

        // Create Weekly Transactions
//        $weeklyTransactions = [];
        $startDate = '2022-02-15';
        $newDate = Carbon::create($startDate);

        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addWeek();

            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p2->id,
                'entry' => 'Weekly match',
                'date' => $newDate->format('Y-m-d'),
                'amount' => 45.00
            ])->create();
//            $weeklyTransactions[] = $transaction;
        }
        // Create Weekly Transactions
//        $weeklyTransactions = [];
        $startDate = '2022-01-15';
        $newDate = Carbon::create($startDate);

        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addWeek();

            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p2->id,
                'entry' => 'Weekly match that shouldnt work',
                'date' => $newDate->format('Y-m-d'),
                'amount' => 45.00
            ])->create();
//            $weeklyTransactions[] = $transaction;
        }
//        $this->transactions[$transaction->entry] = [
//            'period' => 'week',
//            'transactions' => $weeklyTransactions
//        ];

        // Create 4 Weekly Transactions
//        $fourWeeklyTransactions = [];
        $newDate = Carbon::create('2020-07-01');

        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->add('weeks',4);

            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p3->id,
                'entry' => 'Four Weekly match',
                'date' => $newDate->format('Y-m-d'),
                'amount' => 82.00
            ])->create();
//            $fourWeeklyTransactions[] = $transaction;
        }
//        $this->transactions[$transaction->entry] = [
//            'period' => '4Weekly',
//            'transactions' => $fourWeeklyTransactions
//        ];

        // Create Monthly Transactions
//        $monthlyTransactions = [];
        $newDate = Carbon::create('2021-01-02');

        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addMonth();
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p4->id,
                'entry' => 'Monthly match',
                'date' => $newDate->format('Y-m-d'),
                'amount' => 156.42
            ])->create();
//            $monthlyTransactions[] = $transaction;
        }
//        $this->transactions[$transaction->entry] = [
//            'period' => 'month',
//            'transactions' => $monthlyTransactions
//        ];

        // Create Quarter Transactions
//        $quarterlyTransactions = [];
        $newDate = Carbon::create('2021-01-01');
        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addQuarter();
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p5->id,
                'entry' => 'Quarterly match',
                'date' => $newDate->format('Y-m-d'),
                'amount' => 72.86
            ])->create();
//            $quarterlyTransactions[] = $transaction;
        }
//        $this->transactions[$transaction->entry] = [
//            'period' => 'quarter',
//            'transactions' => $quarterlyTransactions
//        ];

        // Create Annual Transactions
//        $annualTransactions = [];
        $newDate = Carbon::create('2016-12-25');
        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addYear();
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p6->id,
                'entry' => 'Annual match',
                'date' => $newDate->format('Y-m-d'),
                'amount' => 52.00
            ])->create();
//            $annualTransactions[] = $transaction;
        }
//        $this->transactions[$transaction->entry] = [
//            'period' => 'year',
//            'transactions' => $annualTransactions
//        ];

        // Create Transactions with no match
        $date1 = Carbon::create('2021-05-26');
        $date2 = Carbon::create('2021-07-12');
        $date3 = Carbon::create('2021-07-31');
        $date4 = Carbon::create('2021-08-28');
        for ($i = 1; $i < 5; $i++) {
            Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p7->id,
                'entry' => 'NO match',
                'date' => $newDate->format('Y-m-d'),
                'amount' => 9.99
            ])->create();
        }

    }
}
