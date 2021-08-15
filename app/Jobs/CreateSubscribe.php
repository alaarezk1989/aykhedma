<?php

namespace App\Jobs;

use App\Constants\NotificationTypes;
use App\Http\Services\NotificationService;
use App\Mail\CreateSubscribeMail;
use App\Models\Segmentation;
use App\Models\Subscribe;
use App\Repositories\SegmentationRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;

class CreateSubscribe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscribe;
    public $notificationService;
    public $segmentationRepository;

    public function __construct(Subscribe $subscribe)
    {
        $this->subscribe = $subscribe;
    }

    public function handle(NotificationService $notificationService, SegmentationRepository $segmentationRepository)
    {
        $this->notificationService = $notificationService;
        $this->segmentationRepository = $segmentationRepository;

        $users = $this->segmentationRepository->getSegmentationUsers(Segmentation::find($this->subscribe->segmentation_id));

        foreach ($users as $user) {
            if ($this->subscribe->type == NotificationTypes::BY_EMAIL || $this->subscribe->type == NotificationTypes::BY_BOTH) {
                $this->notificationService->sendMail($user, new CreateSubscribeMail($this->subscribe, $user));
            }
            if ($this->subscribe->type == NotificationTypes::BY_PUSH_NOTIFICATION || $this->subscribe->type == NotificationTypes::BY_BOTH) {
                $messageData["title"] = $this->subscribe->title;
                $messageData["body"] = $this->subscribe->body;
                $this->notificationService->sendPush($user, $messageData);
            }
        }
    }
}
