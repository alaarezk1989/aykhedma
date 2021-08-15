<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Group;

class GroupEditedEvent
{
    use Dispatchable, SerializesModels;

    public $group;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ProductEvent constructor.
     * @param group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
        $this->message = 'updated';
        if ($group->wasChanged('active')) {
            $status = $group->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($group);
        $this->objectId = $group->id;
    }


}
