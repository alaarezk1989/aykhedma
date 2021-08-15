<?php

namespace App\Listeners;

use App\Events\BranchDeletedEvent;
use App\Events\BranchEditedEvent;
use App\Events\BranchCreatedEvent;
use App\Http\Services\LogsService;

class BranchListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $logsService;

    /**
     * BranchListener constructor.
     * @param LogsService $logsService
     */
    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * Handle the event.
     *
     * @param BranchEditedEvent $event
     * @return void
     */
    public function handleEditedBranch(BranchEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param BranchDeletedEvent $event
     */
    public function handleDeletedBranch(BranchDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * Handle the event.
     *
     * @param BranchCreatedEvent $event
     * @return void
     */
    public function handleCreatedBranch(BranchCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
