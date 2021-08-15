<?php

namespace App\Constants;

final class DriverOrderStatus
{
    const DRIVER_CANCELED = 1;
    const DRIVER_ACCEPT = 2;


    public static function getList()
    {
        return [
            DriverOrderStatus::DRIVER_CANCELED    => trans("driver_cancelled"),
            DriverOrderStatus::DRIVER_ACCEPT    => trans("driver_accept"),
        ];
    }

    public static function getValue($key)
    {
        $list = self::getList();

        return isset($list[$key]) ? $list[$key] : '';
    }
}
