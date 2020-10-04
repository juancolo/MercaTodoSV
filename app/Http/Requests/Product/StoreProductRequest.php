<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
                'unique:products',
                'min:3','max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'slug' => [
                'required',
                'unique:products',
                'min:3','max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'details' => 'required|min:3|max:80',
            'description' => 'required|min:3|max:200',
            'actual_price'  => 'required|min:4|max:8',
            'old_price' => 'min:4|max:8',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'file' => 'image|mimes:jpeg,bmp,png|size:1250 MB',
            'status' => Rule::in(['ACTIVO', 'INACTIVO'])
        ];
    }
}
