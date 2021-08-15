<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
        $rules =  [
            'active' => '',
        ];

        foreach (config()->get("app.locales") as $key => $lang) {
            $rules[$key.".*"] = "required" ;
        }

        return $rules ;
    }

    public function messages()
    {
        $messages = [
            'en.name.required'=>trans('english_unit_name_required'),
            'ar.name.required'=>trans('arabic_unit_name_required'),
            'en.acronym.required'=>trans('english_unit_acronym_required'),
            'ar.acronym.required'=>trans('arabic_unit_acronym_required'),
            'en.name.alpha'=>trans('english_unit_name_must_be_letters'),
            'ar.name.alpha'=>trans('arabic_unit_name_must_be_letters'),
            'en.acronym.alpha'=>trans('english_unit_acronym_must_be_letters'),
            'ar.acronym.alpha'=>trans('arabic_unit_acronym_must_be_letters'),
        ];

        return $messages;
    }
}
