<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'      => 'required|string|min:2|max:255',
            'email'     => 'required|email|min:2|max:255|unique:users,email',
            'phone'     => 'required|string|min:5|max:20|unique:users,phone',
            'password'  => 'required|string|min:6|max:255'
        ];
    }
}
