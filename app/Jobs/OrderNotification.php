<?php

namespace App\Jobs;

use App\Http\Services\NotificationService;
use App\Http\Services\OrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Order;

class OrderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    public $vendorNotificationTitleMessage;
    public $notificationService;
    public $orderService;

    public function __construct(Order $order, $vendorNotificationTitleMessage)
    {
        $this->order = $order;
        $this->vendorNotificationTitleMessage = $vendorNotificationTitleMessage;
    }

    public function handle(NotificationService $notificationService, OrderService $orderService)
    {
        $this->notificationService = $notificationService;
        $this->orderService = $orderService;

        $vendorAdmins = $this->orderService->getOrderVendorAdmins($this->order);

        $messageData = [];
        foreach ($vendorAdmins as $user) {
            $messageData["title"] = $this->vendorNotificationTitleMessage;
            $messageData["body"] = $this->order;
            $this->notificationService->sendPush($user, $messageData);
        }
    }
}
