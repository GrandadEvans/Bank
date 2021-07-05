<?php

namespace Bank\Models;

use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Transaction extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'entry',
        'payment_method_id',
        'provider_id',
        'amount',
        'balance',
        'remarks'
    ];

    protected $dates = [
        'date'
    ];

    /**
     * Make sure we have a proper date in case a British one was submitted
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Dates::convertBritishDateToMysql($value);
    }

    /**
     * Take debit and credit amounts and return a transaction amount
     *
     * @param  float  $credit
     * @param  float  $debit
     * @param  float  $start
     *
     * @return float
     */
    public static function setAmount(float $credit, float $debit, float $start = 00.00): float
    {
        return ($start + $credit - $debit);
    }

    public function user()
    {
        return $this->belongsTo('Bank\User');
    }

    public function provider()
    {
        return $this->hasOne(Provider::class, 'id', 'provider_id');
    }

    /**
     * A provider can have one preferred method of payment
     */
    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    // Has Many Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_transaction');
    }

    public static function getTransactionScrapeDates()
    {
        $lastDate = DB::table('transactions')
            ->select('date')
            ->orderByDesc('date')
            ->limit(1)
            ->get();

        $dateParts = explode('-', $lastDate[0]->date);
        $lastTransaction = new \DateTime();
        $lastTransaction->setDate($dateParts[0], $dateParts[1], intval($dateParts[2]));

        $dayAfterLastTransaction = $lastTransaction
            ->add(new \DateInterval('P1D'))
            ->format('d/m/Y');

        $date = new \DateTime('now', new DateTimeZone('Europe/London'));
        $yesterday = $date
            ->sub(new \DateInterval('P1D'))
            ->format('d/m/Y');

        return [
            'lastDate' => $dayAfterLastTransaction,
            'yesterday' => $yesterday
        ];
    }

}
