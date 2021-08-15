<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules =[
            'type' => 'required',
            'active' => '',
            'value' => 'required',
            'minimum_order_price' => 'required',
            'expire_date' => 'required',
        ];

        if ($this->method() == "POST") {
            $rules['code'] = 'required';
        }

        foreach (config()->get("app.locales") as $key => $lang) {
            $rules[$key.".*"] = "required" ;
        }
        return $rules ;
    }
}
