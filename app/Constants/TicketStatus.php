<?php

namespace App\Constants;

final class TicketStatus
{
    const PENDING = 1;
    const RESOLVED = 2;


    public static function getList()
    {
        return [
            TicketStatus::PENDING => trans("open"),
            TicketStatus::RESOLVED => trans("closed"),
        ];
    }

    public static function getValue($key)
    {
        $list = self::getList();

        return isset($list[$key]) ? $list[$key] : '';
    }
}
