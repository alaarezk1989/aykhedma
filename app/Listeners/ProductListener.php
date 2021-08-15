<?php

namespace App\Listeners;

use App\Events\ProductCreatedEvent;
use App\Events\ProductEditedEvent;
use App\Events\ProductDeletedEvent;
use App\Http\Services\LogsService;

class ProductListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param ProductEditedEvent $event
     */
    public function handleEditedProduct(ProductEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param ProductDeletedEvent $event
     */
    public function handleDeletedProduct(ProductDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param ProductCreatedEvent $event
     */
    public function handleCreatedProduct(ProductCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
