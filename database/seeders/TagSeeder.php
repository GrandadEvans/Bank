<?php

namespace Database\Seeders;

use Bank\Models\Tag;
use Bank\Models\TagsTransactions;
use Bank\Models\Transaction;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    private $defaultUserId = 1;

    private $realTags = [
        'Shopping',
        'Amazon',
        'Aldi',
        'Lidl',
        'B&M',
        'Quality Save',
        'Iceland',
        'Subscribe & Save',
        'Wilkos',
        'Catalogues',
        'Credit Card Payment',
        'Loan Repayment',
        'Ann\'s Business Income',
        'Ann\'s Business Expenditure',
        'Ann\'s Private Tutorial Income',
        'Income',
        'Ann\'s Wage',
        'Rowan',
        'Rowan\'s Allowance',
        'School Uniform',
        'School',
        'Books',
        'Smart Home',
        'Electronics',
        'Security',
        'Household Furnishings',
        'DIY',
        'Household Maintenance',
        'Disability',
        'Presents',
        'Food',
        'Amazon General',
        'Media Subscriptions',
        'Entertainment',
        'Clothing',
        'Rowan\'s Sport',
        'Pets',
        'Vets',
        'Medication',
        'Essential Maintenance'
    ];

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        // Create all the tags we want
        foreach ($this->realTags as $tag) {
            Tag::factory()->create(['tag' => $tag, 'created_by_user_id' => $this->defaultUserId]);
        }

        // Make sure the transactions have been added first
        if ($transactions = Transaction::all()->count() == 0) {
            $this->call(TransactionsSeeder::class);
        }

        $numTags = count($this->realTags);
        $maxTagsPerTransaction = 4;
        $allTransactions = Transaction::all();
        $allTransactions->each(function($transaction) use ($maxTagsPerTransaction) {
            $numTransactionsToLink = random_int(0, $maxTagsPerTransaction);
            $idsAdded = [];
            for ($i=0; $i<$numTransactionsToLink; $i++) {
                $randomTagString = array_random($this->realTags);
                $randomTagModel = Tag::where('tag', $randomTagString)->get()->first();
                if (!in_array($randomTagModel->id, $idsAdded)) {
                    $transaction->tags()->attach($randomTagModel);
                    $idsAdded[] = $randomTagModel->id;
                }
            }
        });
    }
}
