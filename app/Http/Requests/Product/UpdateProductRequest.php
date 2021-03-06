<?php

namespace App\Http\Requests\Product;

use App\Constants\ProductStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('products')->ignore($this->route('product')),
                'min:3','max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'slug' => [
                'required',
                Rule::unique('products')->ignore($this->route('product')),
                'min:3',
                'max:70'],

            'details' => ['min:3','max:80'],
            'description' => ['min:3','max:200'],
            'actual_price'  => ['min:4','max:8'],
            'old_price' => ['numeric', 'min:0','not_in:0'],
            'category_id' => ['exists:categories,id'],
            'file' => ['image', 'mimes:jpeg,bmp,png'],
            'status' => Rule::in(ProductStatus::ACTIVE, ProductStatus::INACTIVE)
        ];

    }
}
