<?php

namespace App\Http\Services;

use App\Models\User;
use App\Notifications\SendEmail;

class SendGridEmailService implements SendEmailInterface
{
    public function sendMail(User $user, $data)
    {
        if (array_key_exists("link", $data)) {
            return $user->notify(new SendEmail(config("sendgrid." . app()->getLocale() . ".mailTemplateWithUrl"), $data));
        }

        return $user->notify(new SendEmail(config("sendgrid." . app()->getLocale() . ".mailTemplate"), $data));
    }
}
