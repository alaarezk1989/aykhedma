<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Products extends Resource
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
            'category' => $this->category?$this->category->name:'-',
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active ? trans('active') :trans('disabled')
        ];
    }
}
