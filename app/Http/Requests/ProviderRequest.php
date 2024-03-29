<?php

namespace Bank\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Alphametric\Validation\Rules\Equals;

class ProviderRequest extends FormRequest
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
            'name'                => 'between:2,100|required',
            'payment_method_id'   => 'integer|required',
            'regular_expressions' => 'max:1000',
            'remarks'             => 'string|nullable|between:2,255',
            'transaction_id'      => 'integer',
            'find_similar'        => 'boolean'
        ];
    }
}
