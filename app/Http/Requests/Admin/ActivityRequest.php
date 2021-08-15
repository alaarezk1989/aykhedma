<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Config;
use Illuminate\Validation\Rule;

class ActivityRequest extends FormRequest
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
            'active' => '',
            'image' => 'required',
        ];

        foreach (Config::get("app.locales") as $key => $lang) {
//            $rules[$key . '.*'] = "required|regex:/^[\pL\s\-]+$/u|".Rule::unique('activities_translations', 'name')
//                    ->whereNot('activity_id', $this->id) ;
            $rules[$key . '.*'] = "required|regex:/^[\pL\s\-]+$/u";
        }

        if ($this->method() == 'POST') {
            $rules["image"] = "required|dimensions:ratio=1/1";
        }
        if ($this->method() == 'PUT' && $this->file('image')) {
            $rules["image"] = "required|dimensions:ratio=1/1";
        }

        return $rules;
    }
}
