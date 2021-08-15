<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\User;

class UserDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $user;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * UserEvent constructor.
     * @param User $User
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->message = 'deleted';
        $this->objectType = get_class($user);
        $this->objectId = $user->id;
    }
}
