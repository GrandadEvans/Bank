<?php

namespace Bank\Http\Controllers;

use Bank\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;

/**
 * Payment Method Controller
 */
class PaymentMethodController extends Controller
{

    /**
     * Return all payment methods
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return PaymentMethod::all();
    }
}
