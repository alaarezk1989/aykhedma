<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "category_id" => "required",
            'icon' => 'required',
            "code" => "required|unique:products,code,NULL,id,deleted_at,NULL",
            "unit_id" => "required",
            "images.*" => "image|mimes:jpeg,png,jpg,gif,svg|min:1|max:50",
            "per_kilogram" => "required",
        ];

        foreach (config()->get("app.locales") as $key => $lang) {
            $rules[$key.".*"] = "required" ;
        }

        if ($this->isMethod('post')) {
            $rules["icon"] = "required|dimensions:ratio=1/1";
            $rules["images"] = "required|max:50" ;
            $rules["en.name"] = "required|unique:product_translations,name,NULL,id,deleted_at,NULL" ;
            $rules["ar.name"] = "required|unique:product_translations,name,NULL,id,deleted_at,NULL" ;
        }

        if ($this->isMethod("PUT")) {
            if ($this->file('icon')){
                $rules["icon"] = "required|dimensions:ratio=1/1";
            }
            if ($this->file('images')) {
                $rules["images"] = "required|max:50" ;
            }
            $rules["en.name"] = "required|unique:product_translations,name,".$this->en_id;
            $rules["ar.name"] = "required|unique:product_translations,name,".$this->ar_id;
            $rules['code'] = "required|unique:products,code,".$this->id;
        }

        return $rules ;
    }
}
