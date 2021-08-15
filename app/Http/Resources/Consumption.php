<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Consumption extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request  updated_at
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product->name,
            'category_name' => $this->category->name,
            'quantity' => $this->quantity,
        ];
    }
}
