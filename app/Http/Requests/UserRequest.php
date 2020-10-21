<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => 'require|min:3|max:70',
            'last_name' => 'require|min:3|max:70',
            'email' => 'require1|email:rfc,dns',
            'password' => 'require|confirmed|min:8|max:70',
        ];
    }
}
