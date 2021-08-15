<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'first_name' => 'min:2|max:45',
            'last_name' => 'min:2|max:45',
            'email'    => 'nullable|email|required_without:phone|min:2|max:100|unique:users,email,'.auth()->id(),
            'phone'    => 'nullable|required_without:email|regex:/(0)[0-9\s-]{10}/|unique:users,phone,'.auth()->id(),
            'gender'   => 'required',
        ];
    }
}
