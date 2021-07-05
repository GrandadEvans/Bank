<?php

namespace Bank\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Alphametric\Validation\Rules\Equals;

class TagFromJsRequest extends FormRequest
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
            'tag_id' => 'integer',
            'transaction_id' => 'integer',
            'tag_icon' => [
                'string',
                'between:8,100'
            ],
            'default_color' => 'between:6,7',
            'tag_name' => [
                'string',
                'between:2,100'
            ],
            'find_similar' => 'boolean'
        ];
    }
}
