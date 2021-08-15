<?php

namespace App\Events;


use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $user;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * userCreatedEvent constructor.
     * @param user $user
     */
    public function __construct(user $user)
    {
        $this->user = $user;
        $this->message = 'created';
        $this->objectType = get_class($user);
        $this->objectId = $user->id;
    }
}
