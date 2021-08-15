<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VouchersList extends Resource
{
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'value' => $this->value,
            'expire_date' => $this->expire_date,
        ];
    }
}
