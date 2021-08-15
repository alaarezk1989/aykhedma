<?php

namespace App\Http\Requests\Web;

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
        $rules = [
            'first_name' => 'required|min:2|max:45',
            'last_name' => 'required|min:2|max:45',
            'phone' => 'required|min:10|regex:/(0)[0-9\s-]{9}/',
            'gender' => 'required',
        ];
        return $rules;
    }

}
