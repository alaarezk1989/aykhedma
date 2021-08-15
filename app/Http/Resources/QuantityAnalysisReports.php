<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class QuantityAnalysisReports extends Resource
{
    public function toArray($request)
    {
        return [
            'branch_product_id' => $this->product? $this->product->name:'-',
            'boxes' => $this->boxes,
            'per_kilogram'=> $this->product?$this->product->per_kilogram:'-',
            'kilos' => $this->kilos,
        ];
    }
}
