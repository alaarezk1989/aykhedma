<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            "value" => "required|numeric|min:0|not_in:0",
            "type" => "required|numeric",
            "from_date" => "required||after:yesterday",
            "to_date" => "required|date|after:from_date",
            "minimum_order_price" => "required|numeric|min:0|not_in:0",
            "usage_no" => "required|numeric",
        ];

        foreach (config()->get("app.locales") as $key => $lang) {
            $rules[$key.".*"] = "required" ;
        }
        return $rules ;
    }
}
