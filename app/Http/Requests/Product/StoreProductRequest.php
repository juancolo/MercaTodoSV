<?php

namespace App\Http\Requests\Product;

use App\Concerns\HasProductValidationRules;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    use HasProductValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}
