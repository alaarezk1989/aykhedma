<?php

namespace App\Constants;

final class ActualShipmentStatus
{
    const SUBMITTED = 1;
    const ASSIGNED = 2;
    const ACCEPTED = 3;
    const PACKED = 4;
    const CANCELLED = 5;
    const DELIVERED = 6;


    public static function getList()
    {
        return [
            ActualShipmentStatus::SUBMITTED => trans("submitted"),
            ActualShipmentStatus::ASSIGNED  => trans("assigned"),
            ActualShipmentStatus::ACCEPTED => trans("accepted"),
            ActualShipmentStatus::PACKED => trans("packed"),
            ActualShipmentStatus::CANCELLED => trans("cancelled"),
            ActualShipmentStatus::DELIVERED => trans("delivered"),
        ];
    }

    public static function getValue($key)
    {
        $list = self::getList();

        return isset($list[$key]) ? $list[$key] : '';
    }

    public static function getStatusesValues()
    {
        $values=[];
        foreach (ActualShipmentStatus::getList() as $key => $value) {
            $values[]=$key;
        }
        return $values;
    }
}
