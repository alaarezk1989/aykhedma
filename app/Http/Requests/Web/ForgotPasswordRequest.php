<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ForgotPasswordRequest extends FormRequest
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
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        session()->flash('error', trans('something_went_wrong'));
        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'email' => 'required|email|exists:users,email,deleted_at,NULL',
        ];

        return $rules ;
    }

    public function messages()
    {
        return [
            'email.required'=>trans('email_required'),
            'email.exists'=>trans('email_not_exists'),
            'email.email'=>trans('email_email_validation'),
        ];
    }
}
