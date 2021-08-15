<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Group;

class GroupDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $group;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * groupEvent constructor.
     * @param group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
        $this->message = 'deleted';
        $this->objectType = get_class($group);
        $this->objectId = $group->id;
    }
}
