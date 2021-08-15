<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationService
{
    //use Queueable;

    private $SMSService;
    private $pushNotificationService;

    public function __construct(SMSProviderInterface $SMSService, PushNotificationInterface $pushNotificationService)
    {
        $this->SMSService = $SMSService;
        $this->pushNotificationService = $pushNotificationService;
    }

    public function sendSMS(Authenticatable $user, string $text)
    {
        return $this->SMSService->sendSMS($user, $text);
    }

    public function sendMail($user, $mailable)
    {
        Mail::to($user->email)->send($mailable);
        return true;
    }

    public function sendPush(User $user, $message, $dataArray = [])
    {
        return $this->pushNotificationService->sendPush($user, $message, $dataArray);
    }
}
