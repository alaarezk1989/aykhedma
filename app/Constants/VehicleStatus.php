<?php

namespace App\Constants;

final class VehicleStatus
{
    const FREE       = 1;
    const LOADING    = 2;
    const DELIVERING = 3;


    public static function getList()
    {
        return [
            VehicleStatus::FREE    => trans("free"),
            VehicleStatus::LOADING => trans("loading"),
            VehicleStatus::DELIVERING => trans("delivering"),
        ];
    }
}
