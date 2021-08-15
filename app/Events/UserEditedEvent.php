<?php

namespace App\Events;


use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserEditedEvent
{
    use Dispatchable , SerializesModels;
    public $user;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * UserEditedEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->message = 'updated';
        if ($user->wasChanged('active')) {
            $status = $user->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($user);
        $this->objectId = $user->id;
    }
}
