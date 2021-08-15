<?php

namespace App\Http\Services;

use App\Models\User;

interface PushNotificationInterface
{
    public function sendPush(User $user, $message, $dataArray = []);
}
