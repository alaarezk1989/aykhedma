<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StockRequest extends FormRequest
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
            'product_id' => 'required',
            'in_amount' => 'required_without_all:out_amount',
            'out_amount' => 'required_without_all:in_amount',
        ];

        if (Request::input('in_amount') != "") {
            $rules['in_amount'] = 'integer|min:0';
        }

        if (Request::input('out_amount')!= "") {
            $rules['out_amount'] = 'integer|min:0';
        }

        if (!Request::input('in_amount') && !Request::input('out_amount')) {
            unset($rules['out_amount']);
        }

        return $rules ;
    }

    public function messages()
    {
        $messages = [
            'product_id.required'=>trans('product_id_required'),
            'in_amount.required_without_all'=>trans('amount_required'),
        ];

        return $messages;
    }
}
