<?php

namespace Bank\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends BaseModel
{
    use HasFactory;

    public static function ScopeList($query)
    {
        $query->distinct()
              ->orderBy('method');
    }
}
