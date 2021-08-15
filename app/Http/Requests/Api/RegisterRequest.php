<?php

namespace App\Http\Requests\Api;

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
            'first_name'       => 'required|min:2|max:45',
            'last_name'        => 'required|min:2|max:45',
            'email'            => 'nullable|email|unique:users,email,NULL,id,deleted_at,NULL',
            'phone'            => 'required|unique:users,phone,NULL,id,deleted_at,NULL|regex:/(0)[0-9\s-]{10}/',
            'password'         => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'type'             => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'       => trans('first_name_required'),
            'last_name.required'        => trans('last_name_required'),
            'user_name.required'        => trans('user_name_required'),
            'email.required'            => trans('email_required'),
            'email.email'               => trans('email_email_validation'),
            'email.unique'              => trans('email_unique_validation'),
            'password.required'         => trans('password_required'),
            'password.min'              => trans('password_min'),
            'confirm_password.required' => trans('confirm_password_required'),
            'confirm_password.same'     => trans('confirm_password_same'),
        ];
    }
}
