<?php

namespace Bank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;

class BaseModel extends Model
{

    /**
     * Set the locale here so it can easily be changed
     */
    public const LOCALE = 'en_GB.UTF-8';
    /**
     * Formatting of the money is as follows
     *
     * % = required for formatting
     * 10 = if possible then pad to 10 characters
     * .2 = to 2 decimal places
     * n = use "£" (use national format) instead of "GBP" (international format)
     */
    public const MONEY_FORMAT = "%10.2n";

    /**
     * Format an amount of money to a standard format
     *
     * @todo This is bodged in order to work in php8, I need to look into NumberFormatter obj
     * @param $value
     *
     * @return string
     */
    public static function formatMoneyForTable($value): string
    {
        setlocale(LC_MONETARY, BaseModel::LOCALE);

        // As described here https://www.php.net/manual/en/function.money-format.php#120479
        // using round so figures are correct
        $value = round($value, 2);

        return  NumberFormatter::formatCurrency($value, 'GBP');
    }

    public function isOwnedByThisUser()
    {
        return (int) $this->user_id === (int) Auth::id();
    }

    public function isNotOwnedByThisUser()
    {
        return ! $this->isOwnedByThisUser();
    }

    public function scopeMyRecords($query)
    {
        return $query->where('user_id', Auth::id())->with('paymentMethod')->limit(5);
    }

    public function verifyRecordOwnership()
    {
        if ($this->isNotOwnedByThisUser()){
            abort(401, 'This is not your transaction to edit');
        }

    }

}
