<?php

namespace Bank\Observers;

use Bank\Models\Transaction;
use Bank\UtilityClasses\InfluxDB;
use DateTime;
use Exception;
use InfluxDB2\Point as InfluxPointer;

/**
 * TransactionObserver
 *
 * A series of Eloquent events that can be attached to or modified etc
 *
 * This Observer is about to be commented out in the AppServiceProvider, that is because the experiment worked, but I
 * see little to no point in duplicating the data, just so that it makes it easy to graph the account data. There's
 * an easy way to do this in MySQL, so I'll find that instead.
 */
class TransactionObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;


    /**
     * Handle the Transaction "created" event.
     *
     * @param Transaction $transaction
     *
     * @return void
     * @throws Exception
     */
    public function created(Transaction $transaction)
    {
        $dateTime = new DateTime($transaction->date);
        $formatted = $dateTime->format("U");

        $pointer = InfluxPointer::measurement('amount')
            ->addTag('user_id', $transaction->id)
            ->addTag('provider', $transaction->provider_id)
            ->addTag('payment_method', $transaction->payment_method_id)
            ->addField('entry', $transaction->entry)
            ->addField('balance', (float)$transaction->balance)
            ->addField('amount', (float)$transaction->amount)
            ->time($formatted);

        InfluxDB::write($pointer);
    }
}
