<?php

namespace App\Http\Requests\Api\Admin\Posts;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'category_id'   => 'required|exists:post_categories,id',
            'lang'          => 'required|string|in:' . $langStr,
            'h1'            => 'required|string|max:255',
            'content'       => 'required|string|max:10000',
            'image'         => 'nullable|image|mimes:jpeg,bmp,png,jpg',
            'description'   => 'nullable|string|max:1000',
            'keywords'      => 'nullable|string|max:1000',
            'is_on_main'    => 'required|boolean',
        ];
    }
}
