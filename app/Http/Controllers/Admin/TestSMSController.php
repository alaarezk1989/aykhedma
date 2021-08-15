<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\NotificationService;
use App\Http\Services\SMSProviderInterface;
use App\Http\Services\NexmoSMSService;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use View;

class TestSMSController extends BaseController
{
    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * TestSMSController constructor.
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function sendSMS()
    {
        $user = User::query()->find("1");
        $isSend = $this->notificationService->sendSMS($user, 'Hello from AyKhedma - Nexmo');

        if ($isSend) {
            return "messages Sent" ;
        }

        return "messages not Sent";
    }

    public function testMailTemplate(Order $order)
    {
        $user = $order->user;
        return View::make('mails.client_new_order_en', ['order' => $order, 'user' => $user]);
    }
}
