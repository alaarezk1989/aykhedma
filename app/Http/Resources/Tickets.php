<?php

namespace App\Http\Resources;

use App\Constants\TicketStatus;
use Illuminate\Http\Resources\Json\Resource;

class Tickets extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user?$this->user->name:'-',
            'title' => $this->title,
            'description' => $this->description,
            'assignee_id' => $this->assignee?$this->assignee->name:'-',
            'status' => TicketStatus::getValue($this->status),
            'created_at' => $this->created_at,
        ];
    }
}
