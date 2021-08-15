<?php


namespace App\Events;

use App\Models\Group;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class GroupCreatedEvent
{
    use Dispatchable , SerializesModels;
    public $group;
    public $message;
    public $objectType;
    public $objectId;

 

    public function __construct(Group $group)
    {
        $this->group = $group;
        $this->message = 'created'; 
        $this->objectType = get_class($group);
        $this->objectId = $group->id;
    }
}
