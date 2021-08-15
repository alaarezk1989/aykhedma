<?php

namespace App\Http\Resources;

use App\Constants\VendorTypes ;
use Illuminate\Http\Resources\Json\Resource;

class Vendors extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'activity_id' => $this->activity->name,
            'name' => $this->name,
            'type' => VendorTypes::getIndex($this->type),
            'active' => $this->active ? trans('active') :trans('disabled')
        ];
    }
}
