<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Locations extends Resource
{
    public function toArray($request)
    {
        return [
            'ancestors' => $this->ancestors,
            'children' => $this->children
        ];
    }
}
