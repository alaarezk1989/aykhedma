<?php

namespace App\Http\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'en.*' => 'required|regex:/^[\pL\s\-]+$/u',
            'ar.*' => 'required|regex:/^[\pL\s\-]+$/u',
            'active' => '',
            "image" => "",
        ];

        if ($this->method() == 'POST') {
            $rules["image"] = "image|mimes:jpeg,png,jpg,gif,svg|max:50|dimensions:ratio=1/1";
        }
        if ($this->method() == 'PUT') {
            $rules['parent_id'] = 'not_in:'.$this->id;
            if ($this->file('image')) {
                $rules["image"] = "image|mimes:jpeg,png,jpg,gif,svg|max:50|dimensions:ratio=1/1";
            }
        }

        return $rules;
    }
}
