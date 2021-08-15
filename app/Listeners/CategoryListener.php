<?php

namespace App\Listeners;

use App\Events\CategoryDeletedEvent;
use App\Events\CategoryEditedEvent;
use App\Events\CategoryCreatedEvent;
use App\Http\Services\LogsService;

class CategoryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $logsService;

    /**
     * CategoryListener constructor.
     * @param LogsService $logsService
     */
    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * Handle the event.
     *
     * @param CategoryEditedEvent $event
     * @return void
     */
    public function handleEditedCategory(CategoryEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param CategoryDeletedEvent $event
     */
    public function handleDeletedCategory(CategoryDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param CategoryCreatedEvent $event
     */
    public function handleCreatedCategory(CategoryCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
