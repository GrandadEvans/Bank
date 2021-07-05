<?php

namespace Bank\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'nextDue',
        'description',
        'amount',
        'remarks',
        'days',
        'type',
        'estimated',
        'payment_method_id'
    ];

    /**
     * Set which fields should be classed as dates and therefore return instances of Carbon
     *
     * @var array
     */
    protected $dates = [
        'nextDue',
        'lastRotated'
    ];

    public static function yesterdays()
    {
        return self::where('nextDue', Carbon::yesterday()->format('Y-m-d'))->get();
    }

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
            $this->attributes['nextDue'] = Dates::convertBritishDateToMysql($value);
        } else {
            $this->attributes['nextDue'] = $value;
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
        return (new Carbon($this->nextDue))->diffForHumans();
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->hasOne(Provider::class, 'id', 'provider_id');
    }

}
