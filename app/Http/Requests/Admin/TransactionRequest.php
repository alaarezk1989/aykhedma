<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TransactionRequest extends FormRequest
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
            'account_type' => 'required',
            'account_id' => 'required',
            'credit' => 'required_without_all:debit',
            'debit' => 'required_without_all:credit',
        ];

        if (Request::input('credit') != "") {
            $rules['credit'] = 'min:0';
        }

        if (Request::input('debit')!= "") {
            $rules['debit'] = 'min:0';
        }

        if (!Request::input('credit') && !Request::input('debit')) {
            unset($rules['debit']);
        }

        return $rules ;
    }

    public function messages()
    {
        $messages = [
            'credit.required_without_all'=>trans('credit_required'),
        ];

        return $messages;
    }
}
