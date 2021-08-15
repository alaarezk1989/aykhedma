<?php

namespace App\Constants;

final class OccurrenceTypes
{
    const DAILY=1;
    const WEEKLY = 2;
    const MONTHLY = 3;

    public static function getList()
    {
        return [
            OccurrenceTypes::DAILY => trans("daily"),
            OccurrenceTypes::WEEKLY => trans("weekly"),
            OccurrenceTypes::MONTHLY => trans("monthly"),
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
