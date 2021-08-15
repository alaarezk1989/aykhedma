<?php

namespace App\Listeners;

use App\Events\TicketEditedEvent;
use App\Events\TicketDeletedEvent;
use App\Events\TicketCreatedEvent;
use App\Http\Services\LogsService;

class TicketListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    /**
     * @param TicketEditedEvent $event
     */
    public function handleEditedTicket(TicketEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    /**
     * @param TicketDeletedEvent $event
     */
    public function handleDeletedTicket(TicketDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
    
    public function handleCreatedTicket(TicketCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

}
