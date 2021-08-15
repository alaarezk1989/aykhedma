<?php

namespace App\Http\Requests\Admin;

use App\Constants\BranchTypes;
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
        $rules = [
            'region_id' => 'required_without:district_id',
            'district_id' => 'required_without:region_id',
            'delivery_fee' => 'required',
        ];

        if (request()->get('branch_type') == BranchTypes::RETAILER) {
            $rules["delivery_sla"] = "required";
        }

        return $rules;
    }
}
