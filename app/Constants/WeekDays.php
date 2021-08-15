<?php

namespace App\Constants;

final class WeekDays
{

    const SATURDAY = 1 ;
    const SUNDAY = 2 ;
    const MONDAY = 3 ;
    const TUESDAY = 4 ;
    const WEDNESDAY = 5 ;
    const THURSDAY = 6 ;
    const FRIDAY = 7 ;

    public static function getList()
    {
        return [
            WeekDays::SATURDAY =>trans("saturday") ,
            WeekDays::SUNDAY =>trans("sunday") ,
            WeekDays::MONDAY =>trans("monday") ,
            WeekDays::TUESDAY =>trans("tuesday") ,
            WeekDays::WEDNESDAY =>trans("wednesday") ,
            WeekDays::THURSDAY =>trans("thursday") ,
            WeekDays::FRIDAY =>trans("friday") ,
        ];
    }

    public static function days()
    {
        return [
            WeekDays::SATURDAY =>"saturday",
            WeekDays::SUNDAY =>"sunday",
            WeekDays::MONDAY =>"monday",
            WeekDays::TUESDAY =>"tuesday",
            WeekDays::WEDNESDAY =>"wednesday",
            WeekDays::THURSDAY =>"thursday",
            WeekDays::FRIDAY =>"friday",
        ];
    }

    public static function getDay($key)
    {
        return self::days()[$key];
    }

    public static function getOne($key)
    {
        return self::getList()[$key];
    }
}
