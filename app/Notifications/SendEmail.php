<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SendGridMessage;

class SendEmail extends Notification
{

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $templateId;
    protected $payload  ;

    public function __construct($templateId, $payload = [])
    {
        $this->templateId = $templateId;
        $this->payload = $payload ;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['sendgrid'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSendGrid($notifiable)
    {
        return (new SendGridMessage($this->templateId))
            ->payload($this->payload)
            ->from('welcome@ai5edma.com', 'Ai5edma')
            ->to($notifiable->email, $notifiable->first_name);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

/**
 * $user = User::find(1);
 *   $user->notify(new SendMail());
 *
 */
