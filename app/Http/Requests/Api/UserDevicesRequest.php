<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserDevicesRequest extends FormRequest
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
            'model' => 'required',
            'os' => 'required',
            'token'=>'required',
        ];
    }

    public function getValidatorInstance()
    {
        $this->request->set('user_id', auth()->user()->id);

        return parent::getValidatorInstance();
    }
}
