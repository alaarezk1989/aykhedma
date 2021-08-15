<?php

namespace App\Events;


use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserLoggedEvent
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
        $this->message = 'Logged';
        $this->objectType = get_class($user);
        $this->objectId = $user->id;
    }
}
