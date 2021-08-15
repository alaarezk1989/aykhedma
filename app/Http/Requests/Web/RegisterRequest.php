<?php

namespace App\Http\Requests\Web;

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
            'first_name'    => 'required|alpha',
            'last_name' => 'required|alpha',
            'user_name' => 'required|alpha',
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:8', 
            'confirm_password' => 'required|same:password', 
        ];
    }

    public function messages()
    { 
        return [
            'first_name.required'=>trans('first_name_required'),
            'last_name.required'=>trans('last_name_required'),
            'user_name.required'=>trans('user_name_required'),
            'first_name.alpha'=>trans('first_name_should_be_characters'),
            'last_name.alpha'=>trans('last_name_should_be_characters'),
            'user_name.alpha'=>trans('user_name_should_be_characters'),
            'email.required'=>trans('email_required'),
            'email.email'=>trans('email_email_validation'),
            'email.unique'=>trans('email_unique_validation'),
            'password.required'=>trans('password_required'),
            'password.min'=>trans('password_min'),
            'confirm_password.required'=>trans('confirm_password_required'),
            'confirm_password.same'=>trans('confirm_password_same'),
        ];
    }
}
