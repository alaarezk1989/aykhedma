<?php

namespace App\Http\Requests\Admin;

use App\Constants\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_id' => 'required',
            'address_id' => 'required',
            'type' => 'required',
        ];

        if ($this->filled('status') && $this->request->get('status') == OrderStatus::ASSIGNED) {
            $rules['driver_id'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'user_id.required'=>trans('user_id_required'),
            'address_id.required'=>trans('address_id_required'),
        ];
    }
}
