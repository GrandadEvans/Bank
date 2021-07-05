<?php

namespace Bank\Models;

use Carbon\Carbon;
use DateTime;
use \Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Dates extends BaseModel
{
    use HasFactory;

    /**
     * Format a date to a standard format we can use in our tables
     *
     * @param $dateIn
     *
     * @return bool|string
     */
    public static function formatDateForTable($dateIn)
    {
        if ($dateIn instanceof Carbon) {
            $carbon = $dateIn;

        } else {

            try {
                $carbon = new Carbon($dateIn);
            }
            catch(Exception $exception) {
                return false;
            }
        }

        $format = 'D, d M Y'; // Mon 13 Jun 2019

        return $carbon->format($format);
    }

    /**
     * Format a date to a unix timestamp
     *
     * @param $dateIn
     *
     * @return bool|string
     */
    public static function formatDateToUnix($dateIn)
    {
        if ($dateIn instanceof Carbon) {
            $carbon = $dateIn;

        } else {

            try {
                $carbon = new Carbon($dateIn);
            }
            catch(Exception $exception) {
                return false;
            }
        }

        $format = 'U'; // Mon 13 Jun 2019

        return $carbon->format($format);
    }

    /**
     * Increase the given date by the given duration
     *
     * @param  Carbon  $date
     * @param  string  $duration
     *
     * @return string
     */
    public static function bumpDate(Carbon $date, string $duration): string
    {
        return $date
            ->add($duration)
            ->format('Y-m-d');
    }

    /**
     * We can take a DB shorthand duration such as 2m and change it to 2 months
     *
     * @param  string  $short
     *
     * @return string
     */
    public static function makeShortDurationReadable(string $short)
    {
        $multiplier = substr($short, 0, 1);
        $duration = substr($short, 1, 1);
        switch ($duration) {
            case 'd':
                $longDuration = 'days';
                break;
            case 'w':
                $longDuration = 'weeks';
                break;
            case 'm':
                $longDuration = 'months';
                break;
            case 'q':
                $longDuration = 'quarters';
                break;
            case 'y':
                $longDuration = 'years';
        }

        if ($multiplier == 1) {
            $longDuration = Str::singular($longDuration);
        }

        return implode(' ', [$multiplier, $longDuration]);
    }

    /**
     * Take a British date such as 13/06/2019 or 13-06-2019 and make it 2019-06-13
     *
     * @param  mixed
     *
     * @return mixed
     */
    public static function convertBritishDateToMysql($britishDate)
    {
        if ($britishDate instanceof DateTime) {
            return $britishDate->format('Y-m-d');
        }

        $british = false;

        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $britishDate)) {
            $british = true;
            $delimiter = '-';
        } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $britishDate)) {
            $british = true;
            $delimiter = '/';
        }

        if ($british) {
            $parts = explode($delimiter, $britishDate);
            $reverseParts = array_reverse($parts);
            $dateOut = join('-', $reverseParts);
        } else {
            $dateOut = $britishDate;
        }

        return $dateOut;
    }

    public function setUser_idAttribute()
    {
        return Auth::id();
    }

}
