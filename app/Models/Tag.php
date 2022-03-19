<?php

namespace Bank\Models;

use Bank\UtilityClasses\ColorUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(mixed $tag_id)
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
        'created_by_user_id',
        'default_color',
        'contrasted_color',
        'icon'
    ];

    public function getContrastedTagColorAttribute()
    {
        return ColorUtilities::blackWhiteContrast($this->default_color);
    }

    public function setContrastedColorAttribute($value)
    {
        $this->attributes['contrasted_color'] = ColorUtilities::blackWhiteContrast($this->default_color);
    }

    // Has Many Transactions
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'tag_transaction');
    }

}
