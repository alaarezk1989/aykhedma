<?php

namespace App\Constants;

final class NotificationTypes
{

    const BY_EMAIL = 1 ;
    const BY_PUSH_NOTIFICATION   = 2 ;
    const BY_BOTH   = 3 ;

    public static function getList()
    {
        return [
            NotificationTypes::BY_EMAIL =>trans("by_email") ,
            NotificationTypes::BY_PUSH_NOTIFICATION => trans("by_push_notification"),
            NotificationTypes::BY_BOTH => trans("both_email_and_push_notification"),
        ];
    }

    public static function getOne($index = '')
    {
        $list = self::getList();
        $list_one = '';
        if ($index) {
            $list_one = $list[$index];
        }
        return $list_one;
    }
}
