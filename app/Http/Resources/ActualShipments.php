<?php

namespace App\Http\Resources;

use App\Constants\RecurringTypes;
use App\Constants\WeekDays;
use Illuminate\Http\Resources\Json\Resource;

class ActualShipments extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->parent_id == null? trans('parent'):trans("child"),
            'parent_id' => $this->parent_id,
            'from_address' => $this->from ? $this->fromAddress->name : '-',
            'to_address' => $this->to ? $this->toAddress->name : '-',
            'from_date' => $this->from_time,
            'to_date' => $this->to_time,
            'cutoff' => $this->cutoff,
            'Vehicle' => $this->vehicle ? $this->vehicle->name :'-',
            'driver' => $this->vehicle ? $this->vehicle->driver?$this->vehicle->driver->name:'-':'-',
            'delivery_person' => $this->deliveryPerson?$this->deliveryPerson->first_name." ".$this->deliveryPerson->last_name:'-',
            'capacity' => $this->capacity,
            'load' => ceil(($this->load/$this->capacity)*100). "%",
        ];
    }
}
