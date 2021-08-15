<?php

namespace App\Http\Requests\Api;

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
            'location_id' => 'required',
            'building' => 'required',
            'street' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'location_id.required'=>trans('location_id_required'),
            'building.required'=>trans('building_required'),
            'street.required'=>trans('street_required'),
        ];
    }

    public function getValidatorInstance()
    {
        $this->request->set('user_id', auth()->user()->id);

        return parent::getValidatorInstance();
    }
}
