<?php

namespace App\Http\Requests\Api\Admin\Products;

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
        $lang = config('app.supported_locales');
        $langStr = '';
        foreach ($lang as $item) {
            $langStr .= $item . ',';
        }

        return [
            'subcategory_id'            => 'required|exists:product_subcategories,id',
            'map_id'                    => 'required|exists:maps,id',
            'lang'                      => 'required|string|in:' . $langStr,

            'name'                      => 'required|string|min:1|max:255',
            'description'               => 'nullable|string|min:1|max:10000',
            'maker'                     => 'nullable|string|min:1|max:255',

            'images'                    => 'nullable|array',
            'images.*'                  => 'nullable|array',
            'images.*.image'            => 'nullable|image|mimes:jpeg,bmp,png,jpg',
        ];
    }
}
