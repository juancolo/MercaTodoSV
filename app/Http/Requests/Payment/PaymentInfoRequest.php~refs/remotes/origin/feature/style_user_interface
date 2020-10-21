<?php

namespace App\Http\Requests\Payment;

use Faker\Provider\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentInfoRequest extends FormRequest
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
            'first_name' => [
                'required',
                'min:3',
                'max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'last_name' => [
                'required',
                'min:3',
                'max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'email' =>[
                'required'
                ,'email:rfc'],

            'document_type' => Rule::in(['CC', 'CE']),
            'document_number' => ['required','numeric'],

            'state' => [
                'required',
                'min:3','max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'street' => [
                'required',
                'min:3',
                'max:70'],

            'zip' => [
                'required',
                'min:5',
                'max:8'
                ],

            'mobile' => [
                'required',
                'numeric',
                'digits:10'
            ]


        ];
    }
}
