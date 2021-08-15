<?php

namespace App\Http\Services;

use App\Models\User;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class FirebaseService implements PushNotificationInterface
{
    public function sendPush(User $user, $message, $dataArray = [])
    {
        $optionBuilder = new OptionsBuilder();
        $notificationBuilder = new PayloadNotificationBuilder($message['title']);
        $notificationBuilder->setBody($message["body"])->setSound('default');

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();

        $downstreamResponse = '';
        $token = false;

        //$token = "dozSc_M8ZGY:APA91bEjNP90Wac81hd1iGsN1Iupp4ef-dI-IVuoZuyba4vGVPus9SwNK5Vz3re22RKcLlaZek4ju2t7rHZGcX3vyAnt2EUC3s0pzY1_TJMWYNic8jOSxQAJEf8G2rVm5PvYkDX3ypQn";
        foreach ($user->devices as $device) {
            $token = $device->token;
            $downstreamResponse = FCM::sendTo($token, $option, $notification);
        }

        if ($token) {
            //echo $token;die;
            return  $downstreamResponse->numberSuccess();
        }
    }
}
