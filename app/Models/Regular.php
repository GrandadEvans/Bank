<?php

namespace Bank\Models;

use Bank\UtilityClasses\Dates;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Regular extends BaseModel
{
    use HasFactory;

    /**
     * Set the fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'next_due',
        'amount',
        'period_name',
        'period_multiplier',
        'remarks',
        'type',
        'amount_varies',
        'payment_method_id',
        'provider_id'
    ];

    /**
     * Set which fields should be classed as dates and therefore return instances of Carbon
     *
     * @var array
     */
    protected $dates = [
        'next_due',
        'last_rotated'
    ];

    /**
     * @return mixed
     */
    public static function yesterdays()
    {
        return self::where('next_due', Carbon::yesterday()->format('Y-m-d'))->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeMyRecords($query)
    {
        return $query->where('user_id', Auth::id());
    }


    /**
     * Set the transaction's start date.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setNextDueAttribute($value): void
    {
        // If the date is the uk 'dd-mm-yyyy' then send it to be converted to sql format
        if (preg_match('/^\d{2}[\/-]\d{2}[\/-]\d{4}$/', $value)) {
            $this->attributes['next_due'] = Dates::convertBritishDateToMysql($value);
        } else {
            $this->attributes['next_due'] = $value;
        }
    }

    /**
     * When the nextDue is requested, make it a readable format
     *
     * @param $value
     *
     * @return string
     *
     * @throws Exception
     */
    public function getFormattedNextDueAttribute($value): string
    {
        return (new Carbon($value))->format('D, d M');
    }

    /**
     * When we request the interval field it should be the diffForHumans from Carbon
     *
     * @return string
     *
     * @throws Exception
     */
    public function getIntervalAttribute(): string
    {
        return (new Carbon($this->next_due))->diffForHumans();
    }

    /**
     * Make sure when we request the amount, it is returned correctly
     *
     * @return string
     */
    public function getFormattedAmountAttribute(): string
    {
        return self::formatMoneyForTable($this->amount);
    }

    /**
     * Convert the DB frequency to a readable format
     *
     * @param $value
     *
     * @return string
     */
    public function getFormattedDaysAttribute(): string
    {
        switch ($this->days) {
            case '1w':
                $o = 'Weekly';
                break;
            case '2w':
                $o = 'Fortnightly';
                break;
            case '4w':
                $o = 'Four Weekly';
                break;
            case '1m':
                $o = 'Monthly';
                break;
            case '3m':
                $o = 'Quarterly';
                break;
            case '6m':
                $o = 'Six Monthly';
                break;
            case '1y':
                $o = 'Annually';
                break;
            default:
                $o = strtoupper($this->days);
        }

        return $o;
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class, 'id', 'provider_id');
    }

    /**
     * @return HasOne
     */
    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

}
