<?php


namespace App\Concerns;


use App\Rules\Slug;
use Illuminate\Validation\Rule;
use App\Constants\ProductStatus;

trait HasProductValidationRules
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules($record = null): array
    {
        return [
            'name' => [
                'required',
                'unique:products',
                'min:3', 'max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'slug' => [
                'required',
                new Slug(),
                'unique:products',
                'min:3', 'max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'details' => 'required|min:3|max:80',
            'description' => 'required|min:3|max:200',
            'actual_price' => 'sometimes:required|numeric|min:0|not_in:0',
            'old_price' => 'numeric|min:0|not_in:0',
            'category_id' => 'required|exists:categories,id',
            'tags.*' => 'exists:tags,id',
            'file' => 'image|mimes:jpeg,bmp,png',
            'status' => Rule::in([ProductStatus::ACTIVE, ProductStatus::INACTIVE])
        ];
    }
}
