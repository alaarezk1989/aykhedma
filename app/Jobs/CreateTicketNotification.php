<?php

namespace App\Jobs;

use App\Constants\UserTypes;
use App\Http\Services\NotificationService;
use App\Mail\CreateNewTicketMail;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;

class CreateTicketNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;
    public $notificationService;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

        $supports = User::where('type', UserTypes::ADMIN)->get();
        $messageData = [];
        foreach ($supports as $support) {
            $messageData["title"] = 'new_ticket_opened';
            $messageData["body"] = $this->ticket;
            $this->notificationService->sendPush($support, $messageData);
        }
    }
}
