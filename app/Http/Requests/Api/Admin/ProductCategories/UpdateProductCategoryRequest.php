<?php

namespace App\Http\Requests\Api\Admin\ProductCategories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
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
            'name'          => 'required|string|min:2|max:180',
            'image'         => 'nullable|image|mimes:jpeg,bmp,png,jpg',
        ];
    }
}
