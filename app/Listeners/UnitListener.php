<?php

namespace App\Listeners;

use App\Events\UnitDeletedEvent;
use App\Events\UnitEditedEvent;
use App\Http\Services\LogsService;

class UnitListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $logsService;

    /**
     * UnitListener constructor.
     * @param LogsService $logsService
     */
    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * Handle the event.
     *
     * @param UnitEditedEvent $event
     * @return void
     */
    public function handleEditedUnit(UnitEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param UnitDeletedEvent $event
     */
    public function handleDeletedUnit(UnitDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
