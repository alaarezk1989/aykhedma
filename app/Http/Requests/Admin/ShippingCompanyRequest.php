<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShippingCompanyRequest extends FormRequest
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
            'phone'            => 'required',
            'administrator_email' => 'nullable|email',
            'administrator_phone' => 'nullable|min:3|max:15',
            'email' => 'nullable|email',
        ];

        foreach (config()->get("app.locales") as $lang => $language) {
            $rules[$lang.".name"] = "required" ;
        }


        return $rules ;
    }

    public function messages()
    {
        $messages = [];

        foreach (config()->get("app.locales") as $lang => $language) {
           $messages[$lang.".name.required"] = trans('name_'.$lang.'_required');
           $messages[$lang.".description.required"] = trans('description_'.$lang.'_required');

        }

        return $messages;
    }
}
