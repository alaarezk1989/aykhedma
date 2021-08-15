<?php

namespace App\Listeners;


use App\Events\BranchZonesCreatedEvent;
use App\Events\BranchZonesDeletedEvent;
use App\Events\BranchZonesEditedEvent;
use App\Http\Services\LogsService;

class BranchZoneListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param BranchZonesCreatedEvent $event
     */
    public function handleCreatedZone(BranchZonesCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param BranchZonesEditedEvent $event
     */
    public function handleEditedZone(BranchZonesEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param BranchZonesDeletedEvent $event
     */
    public function handleDeletedZone(BranchZonesDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
