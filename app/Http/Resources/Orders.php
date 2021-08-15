<?php

namespace App\Http\Resources;

use App\Constants\OrderStatus;
use Illuminate\Http\Resources\Json\Resource;

class Orders extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'shipment_id' => $this->shipment_id,
            'parent_shipment_#' => $this->shipment?$this->shipment->parent_id:'-',
            'user_id' => $this->user?$this->user->first_name." ".$this->user->last_name: '-',
            'address_id' => $this->address ? $this->address->location->name  : '-',
            'branch_id' => $this->branch ? $this->branch->name : '-',
            'total_price' => $this->total_price,
            'promo_code' => $this->promo_code?? '-',
            'promo_type' => $this->promo_type,
            'points_used' => $this->points_used??'-',
            'final_amount' => $this->final_amount ?? $this->total_price,
            'created_at' => $this->created_at,
            'expected_delivery_time' => $this->expected_delivery_time,
            'status' => OrderStatus::getValue($this->status)
        ];
    }
}
