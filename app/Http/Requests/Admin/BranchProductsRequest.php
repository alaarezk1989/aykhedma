<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BranchProductsRequest extends FormRequest
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
            'category_id' => 'required',
            'product_id' => 'required|unique_with:branch_products,branch_id, deleted_at,2 = id',
            'price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required'=>trans('category_id_required'),
            'product_id.required'=>trans('product_id_required'),
            'product_id.unique_with'=>trans('product_id_unique_with'),
        ];
    }

    protected function validationData()
    {
        return array_merge($this->request->all(), [
            'deleted_at' => null
        ]);
    }
}
