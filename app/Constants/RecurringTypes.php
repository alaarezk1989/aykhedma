<?php

namespace App\Constants;

final class RecurringTypes
{
    const DAILY    = 30;
    const WEEKLY   = 4;
    const MONTHLY  = 1;
    const ONE_TIME  = 2;

    public static function getList()
    {
        return [
            RecurringTypes::DAILY   => trans("daily"),
            RecurringTypes::WEEKLY   => trans("weekly"),
            RecurringTypes::MONTHLY   => trans("monthly"),
            RecurringTypes::ONE_TIME   => trans("one_time"),
        ];
    }

    public static function getOne($index = '')
    {
        $list = self::getList();
        $listOne = '';
        if ($index) {
            $listOne = $list[$index];
        }
        return $listOne;
    }
}
