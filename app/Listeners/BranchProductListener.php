<?php

namespace App\Listeners;


use App\Events\BranchProductCreatedEvent;
use App\Events\BranchProductDeletedEvent;
use App\Events\BranchProductEditedEvent;
use App\Http\Services\LogsService;

class BranchProductListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param BranchProductCreatedEvent $event
     */
    public function handleCreatedProduct(BranchProductCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param BranchProductEditedEvent $event
     */
    public function handleEditedProduct(BranchProductEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param BranchProductDeletedEvent $event
     */
    public function handleDeletedProduct(BranchProductDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
