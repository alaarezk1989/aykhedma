<?php

namespace App\Listeners;

use App\Events\UserEditedEvent;
use App\Events\UserCreatedEvent;
use App\Events\UserDeletedEvent;
use App\Events\UserLoggedEvent;
use App\Http\Services\LogsService;

class UserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $logsService;

    /**
     * UserListener constructor.
     * @param LogsService $logsService
     */
    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * Handle the event.
     *
     * @param UserEditedEvent $event
     * @return void
     */
    public function handleEditedUser(UserEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
    /**
     * @param UserCreatedEvent $event
     */
    public function handleCreatedUser(UserCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param UserLoggedEvent $event
     */
    public function handleLoggedUser(UserLoggedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param UserDeletedEvent $event
     */
    public function handleDeletedUser(UserDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
