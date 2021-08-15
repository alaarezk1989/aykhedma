<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'logo' => 'required',
            'phone' => 'required|min:3|max:15',
            'mobile' => 'nullable|min:3|max:15',
            'email' => 'nullable|email',
            'administrator_email' => 'nullable|email',
            'administrator_phone' => 'nullable|min:3|max:15',
            'active' => '',
            'activity_id' => 'required',
            'type' => 'required',        ];

        foreach (config()->get("app.locales") as $lang => $language) {
            $rules[$lang.".*"] = "required" ;
        }

        if ($this->method() == 'POST') {
            $rules["logo"] = "required|dimensions:ratio=1/1";
        }

        if ($this->method() == 'PATCH' && $this->file('logo')) {
            $rules["logo"] = "required|dimensions:ratio=1/1";
        }

        return $rules ;
    }
}
