<?php

namespace App\Http\Requests\Api\Admin\Maps;

use Illuminate\Foundation\Http\FormRequest;

class StoreMapRequest extends FormRequest
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
            'name'      => 'required|string|min:2|max:255',
            'lang'      => 'required|string|in:' . $langStr,
            'link'      => 'required|string|min:2|max:5000'
        ];
    }
}
