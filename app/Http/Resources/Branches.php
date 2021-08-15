<?php

namespace App\Http\Resources;

use App\Constants\BranchTypes;
use Illuminate\Http\Resources\Json\Resource;

class Branches extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor?$this->vendor->name:'-',
            'name' => $this->name,
            'address' => $this->address,
            'type' => BranchTypes::getIndex($this->type),
            'latitude' => $this->lat,
            'longitude' => $this->lng,
            'rate' => ceil($this->reviews()->avg('rate')),
            'active' => $this->active ? trans('active') :trans('disabled')
        ];
    }
}
