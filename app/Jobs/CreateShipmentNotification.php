<?php

namespace App\Jobs;

use App\Constants\UserTypes;
use App\Http\Services\NotificationService;
use App\Mail\CreateNewShipmentMail;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;

class CreateShipmentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $shipment;
    public $notificationService;

    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function handle(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

        $vendors = User::where('type', UserTypes::VENDOR)->get();
        $messageData = [];
        foreach ($vendors as $vendor) {
            $messageData["title"] = trans('new_shipment_created');
            $messageData["body"] = $this->shipment;
            $this->notificationService->sendPush($vendor, $messageData);
            //$this->notificationService->sendMail($vendor, new CreateNewShipmentMail($this->shipment));
        }
    }
}
