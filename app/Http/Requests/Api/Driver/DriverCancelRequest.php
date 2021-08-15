<?php

namespace App\Http\Requests\Api\Driver ;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\UserTypes;

class DriverCancelRequest extends FormRequest
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
        $rules = [];
        if (auth()->user()->type == UserTypes::DRIVER) {
            $rules['cancel_reason'] = "required" ;
        }

        return $rules ;
    }
}
