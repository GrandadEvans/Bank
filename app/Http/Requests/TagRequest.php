<?php

namespace Bank\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Alphametric\Validation\Rules\Equals;

class TagRequest extends FormRequest
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
            'tag' => [
                'between:2,100',
                'required'
            ],
            'default_color' => [
                'regex:/^#?(?:[abcdef1234567890]{3}|[abcdef1234567890]{6})$/i'
            ],
            'icon' => [
                'between:8,50'
            ],
            'contrasted_color' => [
                'regex:/^black|white$/'
            ]
        ];
    }
}
