<?php

namespace App\Listeners;

use App\Events\ActivityEditedEvent;
use App\Events\ActivityDeletedEvent;
use App\Events\ActivityCreatedEvent;
use App\Http\Services\LogsService;

class ActivityListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param ActivityEditedEvent $event
     */
    public function handleEditedActivity(ActivityEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param ActivityDeletedEvent $event
     */
    public function handleDeletedActivity(ActivityDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    public function handleCreatedActivity(ActivityCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
