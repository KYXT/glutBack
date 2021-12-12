<?php

namespace App\Http\Requests\Api\Admin\ForumCategories;

use Illuminate\Foundation\Http\FormRequest;

class StoreForumCategoryRequest extends FormRequest
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
            'name'  => 'required|unique:forum_categories,name|string|min:2|max:180'
        ];
    }
}
