<?php

namespace Bank\UtilityClasses;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Date Utilities
 *
 * These are methods, mainly static that are not covered by Laravel or other included libraries
 */
class Dates
{
    /**
     * Format a date to a standard format we can use in our tables
     *
     * @param string|Carbon $dateIn Can either be a string or an instance of Carbon
     *
     * @todo Sort out a decent handler for the exception instead of just returning false
     *
     * @return bool|string
     *
     */
    public static function formatDateForTable(Carbon|string $dateIn): bool|string
    {
        if ($dateIn instanceof Carbon) {
            $carbon = $dateIn;
        } else {
            try {
                $carbon = new Carbon($dateIn);
            }
            catch(Exception) {
                return false;
            }
        }

        $format = 'D, d M Y'; // Mon 13 Jun 2019

        return $carbon->format($format);
    }

    /**
     * Format a date to a unix timestamp
     *
     * @param string|Carbon $dateIn Can either be a string or an instance of Carbon
     *
     * @todo This is almost complete duplicate code... See to it!
     *
     * @return bool|string
     *
     * @todo Sort out a decent handler for the exception instead of just returning false
     */
    public static function formatDateToUnix(Carbon|string $dateIn): bool|string
    {
        if ($dateIn instanceof Carbon) {
            $carbon = $dateIn;
        } else {
            try {
                $carbon = new Carbon($dateIn);
            }
            catch(Exception) {
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
     * We can take a DB shorthand duration such as 2 m and change it to 2 months
     *
     * @param  string  $short
     *
     * @return string
     */
    public static function makeShortDurationReadable(string $short): string
    {
        $multiplier = substr($short, 0, 1);
        $duration = substr($short, 1, 1);
        $longDuration = match ($duration) {
            'd' => 'days',
            'w' => 'weeks',
            'm' => 'months',
            'q' => 'quarters',
            default => 'years',
        };

        if ($multiplier == 1) {
            $longDuration = Str::singular($longDuration);
        }

        return implode(' ', [$multiplier, $longDuration]);
    }

    /**
     * Take a British date such as 13/06/2019 or 13-06-2019 and make it 2019-06-13
     *
     * @param mixed $britishDate The british formatted date string
     *
     * @return Carbon|string
     */
    public static function convertBritishDateToMysql(mixed $britishDate): Carbon|string
    {
        if ($britishDate instanceof DateTime) {
            return $britishDate->format('Y-m-d');
        }

        $british = false;
        $delimiter = '-';

        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $britishDate)) {
            $british = true;
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

    /**
     * Automatically set the user_id property to the id of the logged in user
     *
     * @return int|null
     */
    public function setUser_idAttribute(): int|null
    {
        return Auth::id();
    }

}
