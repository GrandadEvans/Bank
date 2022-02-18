<?php
/**
 * @license https://opensource.org/licenses/LGPL-3.0 GNU Lesser General Public License version 3
 * @package Bank
 * @subpackage UtilityClasses
 */

namespace Bank\UtilityClasses;

use Bank\Models\PossibleRegular;
use Bank\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class to find possible regular entries for a user in the database
 */
class NewRegularFinder
{
    /**
     * This will be a new list of regulars that are found during the scan
     *
     * @var array $possibleRegulars
     */
    public array $possibleRegulars = [];

    /**
     * The number of tests to perform per transaction
     *
     * @var int $numberOfDatesToTest
     */
    public int $numberOfDatesToTest = 4;

    /**
     * The format of the date we want from Carbon
     *
     * @var string $dateFormat
     */
    protected string $dateFormat = 'Y-m-d';

    /**
     * The maximum amount of entries to retrieve and test per potential regular
     *
     * @var int $numberOfDistinctEntries
     */
    protected int $numberOfDistinctEntries = 0;

    /**
     * Constructor
     *
     * @param  bool  $returnFindings  Should the results be returned (not allowed for event listeners)
     * @test    Broadcast the results to the user on the frontend !important!
     */
    public function __construct(bool $returnFindings = true)
    {
        $this->scan();

        if ($returnFindings) {
            return $this->possibleRegulars;
        }
    }

    /**
     * This is the main method that will take care of scanning for new regular transactions
     *
     * @uses \Bank\UtilityClasses\TimePeriods::$availablePeriods to get all applicable time periods
     */
    public function scan(): void
    {
        $distinctEntries = $this->getDistinctEntries();
        $this->numberOfDistinctEntries = $distinctEntries->count();

        $timePeriods = TimePeriods::$availablePeriods;

        foreach ($distinctEntries as $distinctEntry) {
            $this->testEachDistinctEntry(transaction: $distinctEntry, timePeriods: $timePeriods);
        }
    }

    /**
     * This will get a Collection of distinct transactions that are not already part of a regular
     *
     * @return  Collection
     * @uses    \Bank\Models\Transaction::findDistinctEntries() to get a list of repeated transactions for this user
     *
     */
    public function getDistinctEntries(): Collection
    {
        return Transaction::findDistinctEntries(allowRegularEntries: false);
    }

    /**
     * This is past each of the distinct transactions in turn
     *
     * @param  array  $timePeriods
     * @param  Transaction  $transaction
     *
     * @return void
     */
    public function testEachDistinctEntry(Transaction $transaction, array $timePeriods): void
    {
        foreach ($timePeriods as $period) {
            // eg 2 weeks before today
            $carbon = Carbon::now()->copy()->sub($period, 2);

            // If the transaction date is before the earliest point (ie 2 weeks)...
            $isAfter = $transaction->date->isAfter($carbon);
            Log::debug('Date details', [
                'entry' => $transaction->entry,
                'original_date' => Carbon::now()->format('Y-m-d'),
                'period_name' => $period,
                'period_multiplier' => 2,
                'carbon_date' => $carbon->format('Y-m-d'),
                'transaction_date' => $transaction->date->format('Y-m-d'),
                'is_carbon_before_transaction' => $isAfter
            ]);
            if (!$isAfter) {
                Log::debug('Carbon is before the transaction date');
                $similarTransactions = $this->getSimilarTransactions(transaction: $transaction);

                /*
                 * for each transaction list
                 * start at 1st tx
                 * add day, then week, then 4 week etc
                 * When/if one fits, test next tx with same period
                 */
                $countToTest = $this->numberTransactionsToTest(transactions: $similarTransactions);
                Log::debug('Number of tx to test', [$countToTest]);
                for ($i = 0; $i < ($countToTest - 1); $i++) { // the -1 is because we're testing against the date on the next iteration
                    Log::debug('i', [$i]);
//                    foreach ($timePeriods as $periodName) {
                    Log::debug('periodName', [$period]);

                    for ($multiplier = 1; $multiplier <= 4; $multiplier++) {
                        Log::debug('multiplier', [$multiplier]);
                        $transaction = $similarTransactions[$i];
                        $nextTransaction = $similarTransactions[$i + 1];
                        $nextDate = $transaction->date->copy()->sub($period, $multiplier);
                        $range = $this->getRangeOfDates(nextDate: $nextDate);

                        foreach ($range as $date) {
                            $this->checkForMatchingDates($transaction, $nextTransaction, $date, $period);
                        }
                    }
//                    }
                }
            } else {
                Log::debug('Carbon is AFTER transaction');
            }
        }
    }

    /**
     * This will find all transactions that are similar to this one
     *
     * @param  Transaction  $transaction
     * @return  Collection
     * @uses    \Illuminate\Support\Facades\Auth::id to get the current users ID
     * @uses    \Bank\Models\Transaction::where to find similar items
     *
     * @todo    I'm pretty sure this is an n+1 problem
     */
    public function getSimilarTransactions(Transaction $transaction): Collection
    {
        return Transaction::where('user_id', Auth::id())
            ->where('provider_id', $transaction->provider_id)
            ->where('entry', $transaction->entry)
            ->limit($this->numberOfDatesToTest)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Get either the global numberOfDatesToTest or the number of transactions passed; whichever is smaller
     *
     * @param  mixed  $transactions  Can be an int or a Collection
     *
     * @return  int
     */
    public function numberTransactionsToTest(mixed $transactions): int
    {
        if ($transactions instanceof Collection) {
            $transactions = count($transactions);
        }

        return min($this->numberOfDatesToTest, $transactions);
    }

    /**
     * This will return an array of dates
     *
     * If the transaction date falls on a weekend, it will return an array of dates from the preceding Friday
     * up to the following Monday. This will take care of cases whereby business are taken out either the day before or
     * after a weekend, as well as days when the transaction is taken out during weekends.
     * If the transaction is on a weekday, it will simply wrap that date in an array
     *
     * @param  Carbon  $nextDate
     * @return  array
     * @uses    \Carbon\Carbon::MONDAY to get Carbon's version of Monday
     * @uses    \Carbon\CarbonPeriod::create to get a range of dates from the previous Friday to the next Monday
     *
     * @uses    \Carbon\Carbon::FRIDAY to get Carbon's version of Friday
     */
    public function getRangeOfDates(Carbon $nextDate): array
    {
        $dates = [];

        if ($nextDate->isWeekend()) {
            $friday = $nextDate->copy()->previous(Carbon::FRIDAY);
            $monday = $nextDate->copy()->next(Carbon::MONDAY);

            $range = CarbonPeriod::create($friday, $monday);
            foreach($range as $key => $date) {
                $dates[] = $date->format($this->dateFormat);
            }
        } else {
            $dates[] = $nextDate->format($this->dateFormat);
        }

        return $dates;
    }

    /**
     * Check to see if 2 dates match, if they do, then add to the list of final successes
     *
     * @param  Transaction  $transaction
     * @param  Transaction  $nextTransaction
     * @param  string  $dateToCheck
     * @param  string  $period
     *
     * @return  void
     */
    public function checkForMatchingDates(
        Transaction $transaction,
        Transaction $nextTransaction,
        string $dateToCheck,
        string $period
    ): void {

        $transactionDate = $nextTransaction->date->format($this->dateFormat);
        if ($transactionDate === $dateToCheck) {
            $this->addTransactionToPossibleRegulars($transaction, $nextTransaction, $period);
        }
    }

    /**
     * @param  Transaction  $transaction
     * @param  Transaction  $nextTransaction
     * @param  string  $periodName
     *
     * @return void
     *
     * @todo    Figure out how to manage if there are entries with the same entry text but for a different period
     */
    public function addTransactionToPossibleRegulars(
        Transaction $transaction,
        Transaction $nextTransaction,
        string $periodName,
    ): void {
        $collection = PossibleRegular::where('user_id', Auth::id())
            ->where('entry', $transaction->entry)
            ->where('period_name', $periodName)
            ->get();
        if ($collection->count() === 0) {
            $this->persistFindings($transaction->entry, $periodName);
            $this->possibleRegulars[$transaction->entry] = $periodName;
        }
    }

    /**
     * Write the findings to both a timestamped file and a "latest" file, both in a user specific directory
     *
     * @todo REFACTOR: Split this method up an maybe move to a different class
     * @todo: action on failures such as fail to save or copy
     * @todo: Fix file permissions !important!
     * @uses \Bank\UtilityClasses\RegularTransactionUtilities::getRegularScanDirectory to get the correct directory
     * @uses \Carbon\Carbon::now to format the name of the file
     *
     * @return void
     */
    private function persistFindings($entry, $periodName): void
    {
        $pr = new PossibleRegular();
        $pr->entry = $entry;
        $pr->period_name = $periodName;
        $pr->last_Action = 'created';
        $pr->user_id = Auth::id();
        $pr->save();
    }
}
