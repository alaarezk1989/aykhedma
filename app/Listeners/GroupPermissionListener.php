<?php

namespace App\Listeners;

use App\Events\GroupPermissionEditedEvent;
use App\Events\GroupPermissionCreatedEvent;
use App\Events\GroupPermissionDeletedEvent;
use App\Http\Services\LogsService;

class GroupPermissionListener
{

    protected $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }

    public function handleEditedGroupPermission(GroupPermissionEditedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
    public function handleCreatedGroupPermission(GroupPermissionCreatedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
    public function handleDeletedGroupPermission(GroupPermissionDeletedEvent $event)
    {
        $this->logsService->fillLog($event->objectId, $event->objectType, $event->message);
    }
}
