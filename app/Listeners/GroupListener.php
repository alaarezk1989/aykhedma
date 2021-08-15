<?php

namespace App\Listeners;

use App\Events\GroupEditedEvent;
use App\Events\GroupDeletedEvent;
use App\Events\GroupCreatedEvent;
use App\Http\Services\LogsService;

class GroupListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param GroupEditedEvent $event
     */
    public function handleEditedAGroup(GroupEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param GroupDeletedEvent $event
     */
    public function handleDeletedGroup(GroupDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    public function handleCreatedGroup(GroupCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
    
}
