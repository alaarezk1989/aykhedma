<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Events\OrderEditedEvent;
use App\Http\Services\LogsService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class OrderListener
{
    protected $logsService;
    protected $userService;

    /**
     * OrderListener constructor.
     * @param LogsService $logsService
     */
    public function __construct(LogsService $logsService, UserService $userService)
    {
        $this->logsService = $logsService;
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param  OrderEditedEvent  $event
     * @return void
     */
    public function handleEditedOrder(OrderEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }

    public function handleCreatedOrder(OrderCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
