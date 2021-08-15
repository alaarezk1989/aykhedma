<?php

namespace App\Listeners;

use App\Events\TicketReplyCreatedEvent;
use App\Http\Services\LogsService;

class TicketReplyListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    public function handleCreatedTicketReply(TicketReplyCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
