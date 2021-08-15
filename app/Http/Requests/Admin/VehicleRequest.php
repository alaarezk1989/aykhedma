<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Config;

class VehicleRequest extends FormRequest
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
            'type_id'      => 'required',
            'status_id'    => 'required',
            'driver_id'    => 'required',
            'capacity'     => 'required|numeric|min:1',
            'number'     => 'required|min:3',
        ];

        foreach (Config::get("app.locales") as $key => $lang) {
            $rules[$key . '.*'] = "required" ;
        }

        return $rules;
    }

    public function messages()
    {

        return [
            'type_id.required'=>trans('type_is_required'),
            'status_id.required'=>trans('status_is_required'),
            'zone_id.required'=>trans('zone_is_required'),
            'driver_id.required'=>trans('driver_is_required'),
            'capacity.required'=>trans('capacity_is_required'),
            'capacity.numeric'=>trans('capacity_should_be_number'),
            'capacity.min'=>trans('capacity_number_should_be_at_least_1')
        ];
    }
}





