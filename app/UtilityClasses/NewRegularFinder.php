<?php

namespace Bank\UtilityClasses;

use Bank\Models\Regular;
use Bank\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class NewRegularFinder
{
    /**
     * This will be a new list of regulars that are found during the scan
     *
     * @var array
     */
    public array $possibleRegulars = [];

    /**
     * The number of tests to perform per transaction
     *
     * @var int
     */
    public int $numberOfDatesToTest = 4;

    /**
     * The format of the date we want from Carbon
     *
     * @var string
     */
    protected string $dateFormat = 'Y-m-d';

    /**
     * Constructor
     *
     * @param bool  $returnFindings
     */
    public function __construct(bool $returnFindings = true)
    {
        $findings = $this->scan();

        $this->persistFindings($findings);

        if ($returnFindings) {
            return $findings;
        }

        // @todo broadcast the findings to the user !important!
    }

    /**
     * This is the main method that will take care of scanning for new regular transactions
     *
     * @return array
     */
    public function scan(): array
    {
        $distinctEntries = $this->getDistinctEntries();

        $timePeriods = TimePeriods::$availablePeriods;

        foreach($distinctEntries as $distinctEntry) {
            $this->testEachDistinctEntry(transaction: $distinctEntry, timePeriods: $timePeriods);
        }
        return $this->possibleRegulars;
    }

    /**
     * This will get a Collection of distinct transactions that are not already part of a regular
     *
     * @return Collection
     */
    public function getDistinctEntries(): Collection
    {
        return Regular::findDistinctEntries(allowRegularEntries: false);
    }

    /**
     * This is past each of the distinct transactions in turn
     *
     * @param Transaction $transaction
     * @param array $timePeriods
     *
     * @return void
     */
    public function testEachDistinctEntry(Transaction $transaction, array $timePeriods): void
    {
        $similarTransactions = $this->getSimilarTransactions(transaction: $transaction);

        /*
         * for each transaction list
         * start at 1st tx
         * add day, then week, then 4 week etc
         * When/if one fits, test next tx with same period
         */
        $countToTest = $this->numberTransactionsToTest(transactions: $similarTransactions);

        for ($i=0; $i < ($countToTest-1); $i++) { // the -1 is because we're testing against the date on the next iteration
            foreach ($timePeriods as $period) {
                $multiplier = 1;
                if (str_starts_with($period, 'every ')) {
                    $parts = explode(' ', $period);
                    $multiplier = intval($parts[1]);
                    $period = $parts[2];
                }

                $transaction = $similarTransactions[$i];
                $nextTransaction = $similarTransactions[$i+1];
                $nextDate = $transaction->date->copy()->sub($period, $multiplier);

                $range = $this->getRangeOfDates(nextDate: $nextDate);

                foreach ($range as $date) {
                    $this->checkForMatchingDates($transaction, $nextTransaction, $date, $period);
                }
            }
        }
    }

    /**
     * This will find all transactions that are similar to this one
     *
     * @param Transaction $transaction
     *
     * @return Collection
     *
     * @todo I'm pretty sure this is an n+1 problem
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
     * @param mixed $transactions Can be an int or a Collection
     *
     * @return int
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
     * @param Carbon $nextDate
     *
     * @return array
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
     * @param Transaction $transaction,
     * @param Transaction $nextTransaction,
     * @param string $dateToCheck
     * @param string $period
     *
     * @return void
     */
    public function checkForMatchingDates(
        Transaction $transaction,
        Transaction $nextTransaction,
        string      $dateToCheck,
        string      $period
    ): void
    {

        $transactionDate = $nextTransaction->date->format($this->dateFormat);
        if ($transactionDate === $dateToCheck) {
            $this->addTransactionToPossibleRegulars($transaction, $nextTransaction, $period);
        }
    }

    /**
     * @param Transaction $transaction
     * @param Transaction $nextTransaction
     * @param string $period
     *
     * @return void
     *
     * @todo    Figure out how to manage if there are entries with the same entry text but for a different period
     */
    public function addTransactionToPossibleRegulars(
        Transaction $transaction,
        Transaction $nextTransaction,
        string $period,
    ): void {
        if (!array_key_exists($transaction->entry, $this->possibleRegulars)) {
//            $this->possibleRegulars[$transaction->entry]['transactions'][] = $transaction;
//            $this->possibleRegulars[$transaction->entry]['period'] = $period;
            $this->possibleRegulars[$transaction->entry] = $period;
        }
//        $this->possibleRegulars[$transaction->entry]['transactions'][] = $nextTransaction;
    }

    /**
     * Write the findings to both a timestamped file and a "latest" file, both in a user specific directory
     *
     * @param  array  $findings
     *
     * @return void
     */
    private function persistFindings(array $findings): void
    {
        $dir = RegularTransactionUtilities::getRegularScanDirectory();

        if (!file_exists($dir)) {
            if (!mkdir($dir, 0777)) {
                // @todo: Fix permissions
                // @todo: Catch and action error
            }
        }
        $path = Carbon::now()->format('Y-m-d_H-i-s');
        $latest_filename = 'latest';
        $ext = '.json';
        $filename = $dir.$path.$ext;
        $latest_path = $dir.$latest_filename.$ext;

        $fp = fopen($filename, "w+");
        fwrite($fp, json_encode($findings));
        fclose($fp);

        if (!copy($filename, $latest_path)) {
            // @todo: action error if false
        }
    }
}
