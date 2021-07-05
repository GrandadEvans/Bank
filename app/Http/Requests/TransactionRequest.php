<?php

namespace Bank\Http\Requests;

use Alphametric\Validation\Rules\Equals;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
                'between:8,30'
            ],
            'entry' => [
                'string',
                'required',
                'between:3,255'
            ],
            'payment_method_id' => [
                'required'
            ],
            'provider_id' => [
                'required'
            ],
            'amount' => [
                'required',
                'numeric',
                'regex:/^-?\d{1,4}(\.\d{0,2})?$/',
                'max:2000' // £-9999.99
            ],
            'balance' => [
                'required',
                'numeric',
                'regex:/^-?\d{1,4}(\.\d{0,2})?$/',
                'max:2000' // £-9999.99
            ],
             'remarks' => [
                'string',
                'nullable',
                'between:3,255'
            ],
        ];
    }
}
