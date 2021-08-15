<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\GroupPermission;

class GroupPermissionCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $groupPermission;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * GroupPermissionEvent constructor.
     * @param GroupPermission $GroupPermission
     */
    public function __construct(GroupPermission $groupPermission)
    {
        $this->groupPermission = $groupPermission;
        $this->message = 'created';
        $this->objectType = get_class($groupPermission);
        $this->objectId = $groupPermission->id;
    }
}
