<?php

namespace App\Listeners;

use App\Events\ShippingCompanyEditedEvent;
use App\Events\ShippingCompanyDeletedEvent;
use App\Events\ShippingCompanyCreatedEvent;
use App\Http\Services\LogsService;

class ShippingCompanyListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param ShippingCompanyEditedEvent $event
     */
    public function handleEditedShippingCompany(ShippingCompanyEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param ShippingCompanyDeletedEvent $event
     */
    public function handleDeletedShippingCompany(ShippingCompanyDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    public function handleCreatedShippingCompany(ShippingCompanyCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
