<?php

namespace App\Http\Resources;

use App\Constants\PromotionTypes;
use Illuminate\Http\Resources\Json\Resource;

class Coupons extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'code' => $this->code,
            'type' => PromotionTypes::getOne($this->type),
            'value' => $this->value,
            'minimum_order_price' => $this->minimum_order_price,
            'expire_date' => $this->expire_date,
            'vendor' => $this->vendor? $this->vendor->name: "-",
            'branch' => $this->branch? $this->branch->name: "-",
            'segmentation' => $this->segmentation? $this->segmentation->title: "-",
        ];
    }
}
