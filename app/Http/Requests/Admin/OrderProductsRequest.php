<?php

namespace App\Http\Requests\Admin;

use App\Constants\OrderTypes;
use Illuminate\Foundation\Http\FormRequest;

class OrderProductsRequest extends FormRequest
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
            'branch_id' => 'required',
            'branch_product_id' => 'required',
            'quantity' => 'required',
        ];

        if ($this->request->get('order_type') == OrderTypes::SHIPMENT) {
            $rules['shipment_id'] = "required";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'branch_product_id.required'=>trans('branch_product_id_required'),
            'quantity.required'=>trans('quantity_required'),
        ];
    }
}
