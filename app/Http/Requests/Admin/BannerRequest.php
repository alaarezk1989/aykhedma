<?php

namespace App\Http\Requests\Admin;

use App\Constants\BannerTypes;
use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'type' => 'required'
        ];
        if ($this->isMethod('post')) {
            $rules["image"] = "required|image|dimensions:ratio=2/1|max:50" ;
        }
        if (!$this->isMethod('post')) {
            $rules["image"] = "dimensions:ratio=2/1|max:50" ;
        }
        if ($this->type==BannerTypes::BRANCH_BANNER) {
            $rules['vendor_id'] = "required";
            $rules['branch_id'] = "required";
        }

        return $rules ;
    }

}
