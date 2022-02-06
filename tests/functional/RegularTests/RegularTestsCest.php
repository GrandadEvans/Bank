<?php

use Bank\Models\Provider;
use Bank\Models\Transaction;
use Bank\Models\User;
use Bank\UtilityClasses\NewRegularFinder;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

class RegularTestsCest
{
    protected User      $user;

    protected Provider  $provider;

    protected array     $transactions = [];

    protected string    $dateFormat = 'Y-m-d';

    /**
     * Run before EACH test
     *
     * @param  FunctionalTester  $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->callArtisan('db:seed --class=BaseSeeder');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
        $this->provider = Provider::factory()->create();

        $this->createVastTransactionsList();
    }

    /**
     * Get a list of distinct transactions by the entry field (belonging to this user)
     *
     * @param FunctionalTester $I
     * @test
     *
     * @return void
     */
    public function we_can_get_a_list_of_distinct_entries(FunctionalTester $I)
    {
        /*
         * There should be 7 distinct entries
         * 1. Daily
         * 2. Weekly
         * 3. 4 Weekly
         * 4. Monthly
         * 5. Quarterly
         * 6. Annual
         * 7. NO match
         */
        $RT = new NewRegularFinder();
        $entries = $RT->getDistinctEntries();

        assertCount(7, $entries);

        // And they should be of the correct type
        assertInstanceOf(Collection::class, $entries);
        assertInstanceOf(Transaction::class, $entries[0]);

    }

    /**
     * Get an array of dates when the initial transaction date is on a weekend
     *
     * @param FunctionalTester $I
     * @test
     *
     * @return void
     */
    public function we_get_correct_range_of_dates_covering_weekend(FunctionalTester $I)
    {
        $startDate = Carbon::create('2022-01-01'); // Saturday

        $RT = new NewRegularFinder();
        $actualRange = $RT->getRangeOfDates($startDate);
        $expectedRange = [
            '2021-12-31',
            '2022-01-01',
            '2022-01-02',
            '2022-01-03'
        ];
        assertEquals($expectedRange, $actualRange);
    }

    /**
     * Get an array of dates when the initial transaction date is on a weekday
     *
     * @param FunctionalTester $I
     * @test
     *
     * @return void
     */
    public function we_get_single_date_covering_weekday(FunctionalTester $I)
    {
        $startDate = Carbon::create('2022-01-04'); // Tuesday

        $RT = new NewRegularFinder();
        $actualRange = $RT->getRangeOfDates($startDate);
        $expectedRange = [
            '2022-01-04'
        ];
        assertEquals($expectedRange, $actualRange);
    }

    /**
     * From the initial distinct transaction list, we can take one of the and get all the recent similar transactions.
     *
     * @param FunctionalTester $I
     * @test
     *
     * @return void
     */
    public function we_get_a_list_of_valid_transactions_when_distinct_transaction_given(FunctionalTester $I)
    {
        $tx = Transaction::where('entry', 'Monthly match')->first();
        $RT = new NewRegularFinder();
        $transactionList = $RT->getSimilarTransactions($tx);
        $expectedCount = $RT->numberTransactionsToTest(4); // Temporarily hardcoded

        assertInstanceOf(Collection::class, $transactionList);
        assertCount($expectedCount, $transactionList);
    }

    /**
     * Make sure we get the right number of transactions.
     *
     * @param FunctionalTester $I
     * @test
     *
     * @return void
     */
    public function make_sure_we_get_the_correct_number_of_transactions(FunctionalTester $I)
    {
        $RT = new NewRegularFinder();
        $RT->numberOfDatesToTest = 4;

        // First test with int
        $actualResult = $RT->numberTransactionsToTest(transactions: 3);
        assertEquals(3, $actualResult);

        // and test with a collection
        $collection = new Collection([
            new stdClass(),
            new stdClass(),
            new stdClass()
        ]);
        $actualResult = $RT->numberTransactionsToTest(transactions: $collection);
        assertEquals(3, $actualResult);
    }

    /**
     * @param FunctionalTester $I
     * @return void
     * @test
     */
    public function test_the_entire_setup(FunctionalTester $I)
    {
        $RT = new NewRegularFinder();
        $result = $RT->possibleRegulars;

        assertCount(6, $result);
    }

    /**
     * We now need to set up regular transactions foe ach time period
     *
     * @return void
     */
    protected function createVastTransactionsList(): void
    {
        // Create Daily Transactions
        $dailyTransactions = [];
        for ($i = 1; $i < 5; $i++) {
            $transaction = Transaction::factory([
                'user_id' => $this->user->id,
                'provider_id' => $this->provider->id,
                'entry' => 'Daily match',
                'date' => "2021-01-0{$i}",
                'amount' => 24.75
            ])->create();
            $dailyTransactions[] = $transaction;
        }
        $this->transactions[$transaction->entry] = [
            'period' => 'day',
            'transactions' => $dailyTransactions
        ];

        // Create Weekly Transactions
        $weeklyTransactions = [];
        $startDate = '2020-05-23';
        $newDate = Carbon::create($startDate);

        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addWeek();

            $transaction = Transaction::factory([
                'user_id' => $this->user->id,
                'provider_id' => $this->provider->id,
                'entry' => 'Weekly match',
                'date' => $newDate->format($this->dateFormat),
                'amount' => 45.00
            ])->create();
            $weeklyTransactions[] = $transaction;
        }
        $this->transactions[$transaction->entry] = [
            'period' => 'week',
            'transactions' => $weeklyTransactions
        ];

        // Create 4 Weekly Transactions
        $fourWeeklyTransactions = [];
        $newDate = Carbon::create('2020-07-01');

        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->add('weeks',4);

            $transaction = Transaction::factory([
                'user_id' => $this->user->id,
                'provider_id' => $this->provider->id,
                'entry' => 'Four Weekly match',
                'date' => $newDate->format($this->dateFormat),
                'amount' => 82.00
            ])->create();
            $fourWeeklyTransactions[] = $transaction;
        }
        $this->transactions[$transaction->entry] = [
            'period' => '4Weekly',
            'transactions' => $fourWeeklyTransactions
        ];

        // Create Monthly Transactions
        $monthlyTransactions = [];
        $newDate = Carbon::create('2021-01-02');

        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addMonth();
            $transaction = Transaction::factory([
                'user_id' => $this->user->id,
                'provider_id' => $this->provider->id,
                'entry' => 'Monthly match',
                'date' => $newDate->format($this->dateFormat),
                'amount' => 156.42
            ])->create();
            $monthlyTransactions[] = $transaction;
        }
        $this->transactions[$transaction->entry] = [
            'period' => 'month',
            'transactions' => $monthlyTransactions
        ];

        // Create Quarter Transactions
        $quarterlyTransactions = [];
        $newDate = Carbon::create('2021-01-01');
        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addQuarter();
            $transaction = Transaction::factory([
                'user_id' => $this->user->id,
                'provider_id' => $this->provider->id,
                'entry' => 'Quarterly match',
                'date' => $newDate->format($this->dateFormat),
                'amount' => 72.86
            ])->create();
            $quarterlyTransactions[] = $transaction;
        }
        $this->transactions[$transaction->entry] = [
            'period' => 'quarter',
            'transactions' => $quarterlyTransactions
        ];

        // Create Annual Transactions
        $annualTransactions = [];
        $newDate = Carbon::create('2016-12-25');
        for ($i = 1; $i < 5; $i++) {
            $newDate = $newDate->copy()->addYear();
            $transaction = Transaction::factory([
                'user_id' => $this->user->id,
                'provider_id' => $this->provider->id,
                'entry' => 'Annual match',
                'date' => $newDate->format($this->dateFormat),
                'amount' => 52.00
            ])->create();
            $annualTransactions[] = $transaction;
        }
        $this->transactions[$transaction->entry] = [
            'period' => 'year',
            'transactions' => $annualTransactions
        ];

        // Create Transactions with no match
        $date1 = Carbon::create('2021-05-26');
        $date2 = Carbon::create('2021-07-12');
        $date3 = Carbon::create('2021-07-31');
        $date4 = Carbon::create('2021-08-28');
        for ($i = 1; $i < 5; $i++) {
            Transaction::factory([
                'user_id' => $this->user->id,
                'provider_id' => $this->provider->id,
                'entry' => 'NO match',
                'date' => $newDate->format($this->dateFormat),
                'amount' => 9.99
            ])->create();
        }
    }

//    /**
//     * @param FunctionalTester $I
//     * @return void
//     * @test
//     */
//    public function test_if_the_dates_are_detected_as_equal(FunctionalTester $I)
//    {
//        $RT = new RegularTest();
//        $standardStartDate = '2021-05-15';
//        $correctEndDate = '2021-05-15';
//        $equalString = 'Equal dates';
//        $month = 'month';
//
//        $RT->checkForMatchingDates(
//            transaction: $transaction,
//            nextTransaction: $nextTransaction,
//            dateToCheck: $standardStartDate,
//            period: $month);
//
//        $expectedMatches = [
//            $equalString => [
//                'period' => $month,
//                'dates' => [$standardStartDate, $correctEndDate]
//            ]
//        ];
//
//        assertEquals($RT->possibleRegulars, $expectedMatches);
//
//        $RT->checkForMatchingDates(dateToCheck: '2021-05-15', transaction: '2021-05-15', entry: 'Non Equal dates', period: $month);
//        $expectedMatches = [];
//        assertNotEquals($RT->possibleRegulars, $expectedMatches);
//    }
}
