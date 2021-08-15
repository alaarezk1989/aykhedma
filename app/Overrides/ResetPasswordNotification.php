<?php

namespace App\Overrides;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $actionUrl = url(route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false));
        return (new MailMessage)
            ->subject(trans("forget_password"))
            ->greeting(trans("reset_your_password"))
            ->line(trans("click_to_reset_pass"))
            ->action(trans("reset_password"), $actionUrl);
    }
}