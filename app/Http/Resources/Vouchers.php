<?php

namespace App\Http\Resources;

use App\Constants\PromotionTypes;
use Illuminate\Http\Resources\Json\Resource;

class Vouchers extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'number' => $this->number,
            'value' => $this->value,
            'company_id' => $this->company ? $this->company->name : '-',
            'vendor_id' => $this->vendor ? $this->vendor->name : '-',
            'branch_id' => $this->branch ? $this->branch->name : '-',
            'segmentation_id' => $this->segmentation ? $this->segmentation->title : '-',
            'company_id' => $this->company ? $this->company->name : '-',
            //'activity_id' => $this->activity ? $this->activity->name : '-',
            'expire_date' => $this->expire_date,
            'active' => $this->active ? trans('active') :trans('disabled')
        ];
    }
}
