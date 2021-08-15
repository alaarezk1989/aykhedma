<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressesRequest extends FormRequest
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
        return [
            'region_id' => 'required_without:district_id',
            'district_id' => 'required_without:region_id',
            'building' => 'required',
            'street' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'building.required'=>trans('building_required'),
            'street.required'=>trans('street_required'),
        ];
    }
}
