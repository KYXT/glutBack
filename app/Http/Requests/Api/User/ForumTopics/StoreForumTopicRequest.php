<?php

namespace App\Http\Requests\Api\User\ForumTopics;

use Illuminate\Foundation\Http\FormRequest;

class StoreForumTopicRequest extends FormRequest
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
            'category_id' => 'required|exists:forum_categories,id',
            'title'       => 'required|string|min:10|max:255',
            'text'        => 'required|string|min:10|max:2000'
        ];
    }
}
