<?php

namespace App\Listeners;

use App\Http\Services\LogsService;

use App\Events\LocationUpdatedEvent ;
use App\Events\LocationDeletedEvent ;
use App\Events\LocationCreatedEvent ;

class LocationListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param LocationUpdatedEvent $event
     */
    public function handleUpdatedLocation(LocationUpdatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param LocationDeletedEvent $event
     */
    public function handleDeletedLocation(LocationDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    public function handleCreatedLocation(LocationCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
