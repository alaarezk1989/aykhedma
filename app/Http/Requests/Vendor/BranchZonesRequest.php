<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class BranchZonesRequest extends FormRequest
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
            'zone_id' => 'required',
            'delivery_sla' => 'required',
            'delivery_fee' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'zone_id.required'=>trans('zone_id_required'),
        ];
    }
}
