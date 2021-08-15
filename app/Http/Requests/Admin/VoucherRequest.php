<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'value' => 'required',
            'expire_date' => 'required',
        ];

        if ($this->isMethod('post')) {
            $rules["number"] = "required" ;
        }

        foreach (config()->get("app.locales") as $key => $lang) {
            $rules[$key.".*"] = "required" ;
        }

        return $rules;
    }
}
