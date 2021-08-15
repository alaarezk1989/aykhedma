<?php

namespace App\Listeners;

use App\Events\VendorDeletedEvent;
use App\Events\VendorEditedEvent;
use App\Events\VendorCreatedEvent;
use App\Http\Services\LogsService;

class VendorListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $logsService;

    /**
     * VendorListener constructor.
     * @param LogsService $logsService
     */
    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * Handle the event.
     *
     * @param VendorEditedEvent $event
     * @return void
     */
    public function handleEditedVendor(VendorEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param VendorDeletedEvent $event
     */
    public function handleDeletedVendor(VendorDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param VendorCreatedEvent $event
     */
    public function handleCreatedVendor(VendorCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
