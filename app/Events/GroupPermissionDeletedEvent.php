<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\GroupPermission;

class GroupPermissionDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $groupPermission;
    public $message;
    public $objectType;
    public $objectId;

    
    public function __construct(GroupPermission $groupPermission)
    {
        $this->groupPermission = $groupPermission;
        $this->message = 'deleted';
        $this->objectType = get_class($groupPermission);
        $this->objectId = $groupPermission->id;
    }
}
