<?php

namespace Bank\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Alphametric\Validation\Rules\Equals;

class RegularRequest extends FormRequest
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
            'nextDue' => [
                'date',
                'required',
                'between:8,30'
            ],
            'description' => [
                'string',
                'required',
                'between:3,255'
            ],
            'payment_method_id' => [
                'required',
                'numeric'
            ],
            'amount' => [
                'required',
                'numeric',
                'regex:/^-?\d{1,4}(\.\d{0,2})?$/',
                'max:2000' // £-9999.99
            ],
            'estimated' => [
                'nullable',
                'boolean'
                ],
            'days' => [
                'required',
                'regex:/^\d\w$/'
            ],
            'remarks' => [
                'string',
                'nullable',
                'between:3,255'
            ],
            'provider_id' => [
                'integer'
            ]
        ];
    }
}
