<?php

namespace App\Constants;

final class DaysWeek
{
    const SATURDAY=1;
    const SUNDAY = 2;
    const MONDAY = 3;
    const TUESDAY = 4;
    const WEDNESDAY = 5;
    const THURSDAY = 6;
    const FRIDAY = 7;

    public static function getList()
    {
        return [
            DaysWeek::SATURDAY => trans("saturday"),
            DaysWeek::SUNDAY => trans("sunday"),
            DaysWeek::MONDAY => trans("monday"),
            DaysWeek::TUESDAY => trans("tuesday"),
            DaysWeek::WEDNESDAY => trans("wednesday"),
            DaysWeek::THURSDAY => trans("thursday"),
            DaysWeek::FRIDAY => trans("friday"),
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
