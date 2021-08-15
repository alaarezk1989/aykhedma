<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'amount' => 'required',
            'order_id' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'amount.required' => trans('amount_field_is_required'),
            'order_id.required' => trans('order_id_field_is_required'),
        ];
    }
}
