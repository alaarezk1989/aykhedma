<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Stocks extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product?$this->product->product->name:'-' ,
            'in_amount' => $this->in_amount,
            'out_amount' => $this->out_amount,
            'balance'=> $this->balance,
            'branch'=> $this->product?$this->product->branch->name:'-',
            'vendor'=> $this->product?$this->product->branch->vendor->name:'-',
            'created_by' => $this->user ? $this->user->first_name." ".$this->user->last_name : '-',
            'created_at'=> $this->created_at,
        ];
    }
}
