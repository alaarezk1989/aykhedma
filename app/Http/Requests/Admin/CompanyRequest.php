<?php

namespace  App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'phone' => 'required|regex:/(0)[0-9\s-]{10}/',
            'administrator_email' => 'nullable|email',
            'administrator_phone' => 'nullable|min:3|max:15',
            'email' => 'nullable|email',
        ];

        foreach (config()->get("app.locales") as $lang => $language) {
            $rules[$lang.".name"] = "required" ;
        }

        return $rules ;
    }
}
