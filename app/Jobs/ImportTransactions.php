<?php

namespace Bank\Jobs;

use Bank\Models\PaymentMethod;
use Bank\Models\Transaction;
use Bank\Models\User;
use Bank\UtilityClasses\CsvFileParser;
use ErrorException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Only run a single import until moved to a decent environment
 *
 * I have implemented the shouldBeUnique interface to reduce the overall load on my system,
 * once this is in a "proper" production environment, however, this can be looked again
 *
 * @todo Remove "shouldBeUnique" when moving to a decent server environment
 */
class ImportTransactions implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 2;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        $userId = $this->user->id;
        return [new WithoutOverlapping($userId)];
    }

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->onQueue('importing');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userId = $this->user->id;

        $filename = base_path()."/resources/statements/user_{$userId}/latest.csv";
        Log::debug('file should be stored at '.$filename);
        $imported = new CsvFileParser($filename);
        $data = $imported->getData();

        $transactionList = [];

        DB::beginTransaction();

        foreach ($data as $row) {
            $t = new Transaction();
            $t->date = CsvFileParser::convertDate($row["Transaction Date"]);
            $t->entry = $row["Transaction Description"];
            $t->amount = Transaction::setAmount(floatval($row["Credit Amount"]), floatval($row["Debit Amount"]));
            $t->balance = $row["Balance"];
            $t->user_id = $userId;

//            $providerResults = CsvFileParser::getTransactionsProviders($row["Transaction Description"], $providers);

//            $possibleProviders = count($providerResults);
            if (empty($row['Transaction Type'])) $row['Transaction Type'] = "---";

            try {
                $t->payment_method_id = PaymentMethod::where('abbreviation',
                    $row["Transaction Type"])->get()->first()->id;
            } catch (ErrorException $e) {
                throw new Exception("There was an error saving the transaction. The abbreviation of \"".$row["Transaction Type"]."\" was not recognised.");
            }

            // If there is only 1 possible provider, then set that before we save the transaction
//            if ($possibleProviders === 1) {
//                $t->provider_id = $providerResults[0]['id'];
//            }

            if ( ! $t->save()) {
                throw new Exception("Unable to save the transaction");
            }

//            foreach($providerResults as &$result) {
//                $result['transaction_id'] = $t->id;
//            }

            // If there are multiple providers to choose from, add them to an array to be presented later
//            if ($possibleProviders >= 1) {
//                array_push($multipleProviderMatches, [
//                    'id' => $t->id,
//                    'date' => $t->date,
//                    'entry' => $t->entry,
//                    'amount' => $t->amount,
//                    'providers' => $providerResults
//                ]);
//            }
        }

        DB::commit();
        unlink($filename);
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }

    /**
     * This is not needed until I make an "import" or similar model, to track, and record imports
     *
     * Once I have created and implemented an "import" model (or something similar), I can record things such
     * as the dateTime; uniqueId (needed for the below); number of transactions, time taken to completely
     * finish the import and other useful information
     *
     * @todo Create import model

        public $uniqueFor = 3600; // The number of seconds after which the job's unique lock will be released. (1 hour)

        public function uniqueId() //The unique ID of the job.
        {
            return $this->product->id;
        }
     */

}
