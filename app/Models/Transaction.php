<?php

namespace Bank\Models;

//use Bank\Observers\TransactionObserver;
use Bank\UtilityClasses\Dates;
use DateInterval;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Transaction
 */
class Transaction extends BaseModel
{
    /**
     * Let the model know there is a factory available
     */
    use HasFactory;

//    protected $dispatchesEvents; // Disabled until InfluxDB reinstated

    /**
     * Let Eloquent know which fields can be mass assigned
     *
     * @var array
     */
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

    /**
     * Let Eloquent know which fields are dates and should be made Carbon instances
     *
     * @var array
     */
    protected $dates = [
        'date'
    ];


    /**
     * Make sure we have a proper date in case a British one was submitted
     *
     * @var
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

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('Bank\User');
    }

    /**
     * @return HasOne
     */
    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class, 'id', 'provider_id');
    }

    /**
     * A provider can have one preferred method of payment
     */
    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    // Has Many Tags

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_transaction');
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function getTransactionScrapeDates(): array
    {
        $lastDate = DB::table('transactions')
            ->select('date')
            ->orderByDesc('date')
            ->limit(1)
            ->get();

        $dateParts = explode('-', $lastDate[0]->date);
        $lastTransaction = new DateTime();
        $lastTransaction->setDate($dateParts[0], $dateParts[1], intval($dateParts[2]));

        $dayAfterLastTransaction = $lastTransaction
            ->add(new DateInterval('P1D'))
            ->format('d/m/Y');

        $date = new DateTime('now', new DateTimeZone('Europe/London'));
        $yesterday = $date
            ->sub(new DateInterval('P1D'))
            ->format('d/m/Y');

        return [
            'lastDate' => $dayAfterLastTransaction,
            'yesterday' => $yesterday
        ];
    }

    /**
     * I want to find distinct entries for this user
     *
     * They should obviously be for this user, and distinct on the entry text and the amount
     */
    public static function findDistinctEntries($allowRegularEntries = true)
    {
        return Transaction::where('user_id', Auth::id())
            ->where('isPartOfRegular', $allowRegularEntries)
            ->groupBy('entry')
            ->get();
    }

}
