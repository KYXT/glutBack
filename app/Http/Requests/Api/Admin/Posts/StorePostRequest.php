<?php

namespace App\Http\Requests\Api\Admin\Posts;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title'         => 'required|string|unique:posts,title|min:10|max:255',
            'h1'            => 'required|string|min:10|max:255',
            'content'       => 'required|string|min:10|max:10000',
            'image'         => 'required|image|mimes:jpeg,bmp,png,jpg',
            'description'   => 'nullable|string|min:10|max:1000',
            'keywords'      => 'nullable|string|min:10|max:1000',
            'is_on_main'    => 'nullable|boolean',
        ];
    }
}
