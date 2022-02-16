<?php

namespace Bank\Http\Requests;

use Alphametric\Validation\Rules\Equals;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegularRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                'integer',
                'required'
            ],
            'provider_id' => [
                'integer',
                'required'
            ],
            'payment_method_id' => [
                'integer',
                'required'
            ],
            'amount' => [
                'numeric',
                'regex:/^-?\d{1,4}(\.\d{0,2})?$/',
                'max:2000' // £-9999.99
            ],
            'amount_varies' => [
                'nullable',
                'boolean'
            ],
            'period_name' => [
                'in:day,week,month,quarter,year',
                'required'
            ],
            'period_multiplier' => [
                'between:1,4',
                'required'
            ],
            'remarks' => [
                'string',
                'nullable',
                'between:3,255'
            ],
        ];
    }
}
