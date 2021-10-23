<?php

namespace Bank\UtilityClasses;

use Bank\Models\Transaction;
use DateTime;
use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;

class InfluxDB {

    // You can generate a Token from the "Tokens Tab" in the UI
    private $token = 'oOyTG8cfu8tGdN0nzSaRadKUPTJyuSGzR-G4QzKMOEmY1YI_TAJBEDF4QHmIbg_9r8PfuvEfwCREgyIe5peCkw==';

    private $org = 'Bank';

    private $bucket = 'transactions';

    private $url = "http://localhost:8086";

    public function getClient()
    {
        return new Client([
            "url" => $this->url,
            "token" => $this->token,
        ]);
    }

    public function write(Transaction $transaction) {
//        var_dump($transaction->toArray());
        $writeApi = $this->getClient()->createWriteApi();

        $d = new DateTime($transaction->date);
        $t = $d->format("U"); // v : Milliseconds
        $n = ($t);

        $point = Point::measurement('amount')
            ->addTag('user_id', $transaction->id)
            ->addTag('provider', $transaction->provider_id)
            ->addTag('payment_method', $transaction->payment_method_id)
            ->addField('entry', $transaction->entry)
            ->addField('balance', (float) $transaction->balance)
            ->addField('amount', (float) $transaction->amount)
            ->time($n);

        $writeApi->write($point, WritePrecision::S, $this->bucket, $this->org);
    }
}
