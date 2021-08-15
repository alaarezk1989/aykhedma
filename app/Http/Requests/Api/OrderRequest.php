<?php

namespace App\Http\Requests\Api;

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
        return [
            'user_id' => 'required',
            'address_id' => 'required',
            'products' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'=>trans('user_id_required'),
            'address_id.required'=>trans('address_id_required'),
        ];
    }

    public function getValidatorInstance()
    {
        $this->request->set('user_id', auth()->user()->id);

        return parent::getValidatorInstance();
    }
}
