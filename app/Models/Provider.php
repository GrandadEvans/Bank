<?php

namespace Bank\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * @method static findOrFail(int $providerId)
 * @method static where(string $string, int $providerId)
 */
class Provider extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'remarks',
        'payment_method_id',
        'regular_expressions',
        'logo'
    ];

    /**
     * @var bool
     */

    /**
     * A ProviderSeeder can have many transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * A provider has many regulars
     */
    public function regulars()
    {
        return $this->hasMany(Regular::class);
    }

    /**
     * A provider can have one preferred method of payment
     */
    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    /**
     * Override the all method to bring in the payment methods
     * @param  array  $columns
     */
    public static function all($columns = ['*'])
    {
        return self::with('paymentMethod')->orderBy('name', 'asc');
    }

    public function findTransactions(Provider $provider)
    {
        $regex = trim($provider->regular_expressions, "/");
        return DB::table('transactions')->select('*')->whereRaw('entry REGEXP ?', [$regex])->get();
    }

}
