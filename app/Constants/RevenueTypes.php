<?php

namespace App\Constants;

final class RevenueTypes
{
    const HOLD = 1;
    const REVENUE = 2;

    public static function getList()
    {
        return [
            self::HOLD => trans('hold'),
            self::REVENUE => trans('revenue'),
        ];
    }

    public static function getLabel($role)
    {
        return self::getList()[$role];
    }
}
