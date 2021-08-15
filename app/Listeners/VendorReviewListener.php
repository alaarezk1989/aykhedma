<?php

namespace App\Listeners;

use App\Events\VendorReviewsCreatedEvent;
use App\Events\VendorReviewsDeletedEvent;
use App\Events\VendorReviewsEditedEvent;
use App\Http\Services\LogsService;

class VendorReviewListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param VendorReviewsCreatedEvent $event
     */
    public function handleCreatedVendorReview(VendorReviewsCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param VendorReviewsEditedEvent $event
     */
    public function handleEditedVendorReview(VendorReviewsEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param VendorReviewsDeletedEvent $event
     */
    public function handleDeletedVendorReview(VendorReviewsDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
