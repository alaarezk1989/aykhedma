<?php

namespace App\Jobs;

use App\Http\Services\NotificationService;
use App\Mail\CreateCouponClientMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Coupon;

class CreateCouponNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $coupon;
    public $users;
    public $notificationService;

    public function __construct(Coupon $coupon, $users)
    {
        $this->coupon = $coupon;
        $this->users = $users;
    }

    public function handle(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

        foreach ($this->users as $user) {
            $messageData = [];
            $messageData["title"] = 'new_coupon';
            $messageData["body"] = $this->coupon;
            $this->notificationService->sendPush($user, $messageData);

            $mailable = new CreateCouponClientMail($this->coupon, $user);
            $this->notificationService->sendMail($user, $mailable);
        }
    }
}
