<?php

namespace App\Http\Requests\Api\Admin\ProductSubcategories;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductSubcategoryRequest extends FormRequest
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
            'category_id'   => 'required|integer|exists:product_categories,id',
            'name'          => 'required|unique:product_subcategories,name|string|min:2|max:180',
        ];
    }
}
