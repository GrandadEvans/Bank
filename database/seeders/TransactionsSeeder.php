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
        $carbon = Carbon::now()->sub('day', 5);
        for ($i = 1; $i < 5; $i++) {
            $carbon = $carbon->copy()->add('day', 1);
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p1->id,
                'entry' => 'Daily match',
                'date' => $carbon->format('Y-m-d'),
                'amount' => 24.75
            ])->create();
        }

        // Create weekly
        $carbon = Carbon::now()->sub('week', 5);
        for ($i = 1; $i < 5; $i++) {
            $carbon = $carbon->copy()->add('week', 1);
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p2->id,
                'entry' => 'Weekly match',
                'date' => $carbon->format('Y-m-d'),
                'amount' => 45.00
            ])->create();
        }

        // Create weekly too old
        $carbon = Carbon::now()->sub('week', 20);
        for ($i = 1; $i < 5; $i++) {
            $carbon = $carbon->copy()->addWeeks(3);
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p2->id,
                'entry' => 'Weekly match that shouldnt work',
                'date' => $carbon->format('Y-m-d'),
                'amount' => 45.00
            ])->create();
        }

        // create 4 weekly
        $carbon = Carbon::now()->sub('weeks', 19);

        for ($i = 1; $i < 5; $i++) {
            $carbon = $carbon->copy()->add('weeks', 4);

            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p3->id,
                'entry' => 'Four Weekly match',
                'date' => $carbon->format('Y-m-d'),
                'amount' => 82.00
            ])->create();
        }

        // Create Monthly Transactions
        $carbon = Carbon::now()->sub('month', 5);
        for ($i = 1; $i < 5; $i++) {
            $carbon = $carbon->copy()->addMonth();
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p4->id,
                'entry' => 'Monthly match',
                'date' => $carbon->format('Y-m-d'),
                'amount' => 156.42
            ])->create();
        }

        // Create Quarter Transactions
        $carbon = Carbon::now()->sub('quarter', 5);
        for ($i = 1; $i < 5; $i++) {
            $carbon = $carbon->copy()->addQuarter();
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p5->id,
                'entry' => 'Quarterly match',
                'date' => $carbon->format('Y-m-d'),
                'amount' => 72.86
            ])->create();
        }

        // Create Annual Transactions
        $carbon = Carbon::now()->sub('month', (4 * 12) + 11);
        for ($i = 1; $i < 5; $i++) {
            $carbon = $carbon->copy()->addYear();
            $transaction = Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p6->id,
                'entry' => 'Annual match',
                'date' => $carbon->format('Y-m-d'),
                'amount' => 52.00
            ])->create();
        }

        // Create Transactions with no match
        $dates = [];
        $dates[] = $carbon = Carbon::now()->sub('weeks', 9);
        $dates[] = $carbon->copy()->add('week', 1);
        $dates[] = $carbon->copy()->add('week', 2);
        $dates[] = $carbon->copy()->add('week', 3);
        $dates[] = $carbon->copy()->add('week', 2);
        for ($i = 1; $i < 5; $i++) {
            Transaction::factory([
                'user_id' => 1,
                'provider_id' => $p7->id,
                'entry' => 'NO match',
                'date' => $dates[$i]->format('Y-m-d'),
                'amount' => 9.99
            ])->create();
        }
    }
}
