<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use \App\Constants\UserTypes as UserTypes;

class UserRequest extends FormRequest
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
        $passwordRules = 'min:8|max:100|confirmed';

        $rules = [
            'first_name'        => 'required|min:2|max:45',
            'last_name'   => 'required|min:2|max:45',
            'email'       => 'nullable|email|unique:users,email,NULL,id,deleted_at,NULL',
            'phone'       => 'required|regex:/(0)[0-9\s-]{10}/|unique:users,phone,NULL,id,deleted_at,NULL',
            'type'        => 'required',
            'vendor_id' => 'required_if:type,==,'.UserTypes::VENDOR,
            'branch_id' => 'required_if:type,==,'.UserTypes::DRIVER,
        ];

        if ($this->method() == 'POST') {
            $rules['password'] = $passwordRules;
        }

        if ($this->method() == 'PUT') {
            $rules['first_name'] = $rules['first_name'].",first_name";
            $rules['email'] = $rules['email'].",email,".$this->id;
            $rules['last_name'] = $rules['last_name'].",last_name";
            $rules['phone'] = $rules['phone'].",phone,".$this->id;
            $rules['type'] = $rules['type'];
            $rules['vendor_id'] = $rules['vendor_id'];
            $rules['branch_id'] = $rules['branch_id'];
            if ($this->password) {
                $rules['password'] = $passwordRules;
            }
        }

        if ($this->get('type') == UserTypes::PUBLIC_DRIVER) {
            $rules["branches"] = "required";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => trans('first_name_required'),
            'first_name.min'      => trans('first_name_shoud_be_at_least_2'),
            'first_name.max'      => trans('first_name_shoud_not_be_more_than_45'),
            'last_name.required'  => trans('last_name_required'),
            'last_name.min'       => trans('last_name_shoud_be_at_least_2'),
            'last_name.max'       => trans('last_name_shoud_not_be_more_than_45'),
            'email.required'       => trans('email_required'),
            'email.unique'       => trans('email_already_taken'),
            'phone.required'       => trans('phone_required'),
            'phone.regex'       => trans('phone_should_be_in_right_format_like_01--_and_shoud_be_11_numbers'),
            'type.required'       => trans('user_type_required'),
            'vendor_id.required_if' => trans('vendor_id_required_if_user_type_is_vendor'),
            'branch_id.required_if' => trans('branch_id_required_if_user_type_is_driver'),
            'password.required' => trans('password_required'),
            'password.min' => trans('password_shoud_be_at_least_8'),
            'password.max' => trans('password_shoud_not_be_more_than_45'),
            'password.confirmed' => trans('two_password_should_be_same'),
        ];
    }
}
