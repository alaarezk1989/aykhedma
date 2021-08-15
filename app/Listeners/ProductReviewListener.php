<?php

namespace App\Listeners;

use App\Events\ProductReviewCreatedEvent;
use App\Events\ProductReviewDeletedEvent;
use App\Events\ProductReviewEditedEvent;
use App\Http\Services\LogsService;

class ProductReviewListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param ProductReviewCreatedEvent $event
     */
    public function handleCreatedProduct(ProductReviewCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param ProductReviewEditedEvent $event
     */
    public function handleEditedProduct(ProductReviewEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param ProductReviewDeletedEvent $event
     */
    public function handleDeletedProduct(ProductReviewDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
