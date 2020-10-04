<?php

namespace App\Http\Requests\Payment;

use Faker\Provider\Payment;
use Illuminate\Foundation\Http\FormRequest;

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
            'name'              => ['required','min:3','max:70','regex:/^[^\{\}\[\]\;\<\>]*$/'],
            'slug'              => 'required|min:3|max:70',
<<<<<<< Updated upstream:app/Http/Requests/ProductRequest.php
            'details'           => 'required|min:3|max:80',
            'description'       => 'required|min:3|max:200',
            'actual_price'      => 'numeric|min:4|max:8',
            'old_price'         => 'numeric|min:4|max:8',
=======
            'email'             => 'require1|email:rfc,dns',
>>>>>>> Stashed changes:app/Http/Requests/Payment/PaymentInfoRequest.php
            'category_id'       => 'required|exists:categories,id',
            'tags'              => 'required|array',
            'tags.*'            => 'exists:tags,id',
            'file'              => 'image|mimes:jpeg,bmp,png|size:512',
            'status'            => Rule::in(['ACTIVO', 'INACTIVO'])
        ];
    }
}
