<?php

namespace App\Constants;

final class OrderStatus
{
    const SUBMITTED = 1;
    const ASSIGNED = 2;
    //const PENDING_PACKING = 3;
    //const PENDING_SHIPPING = 4;
    const CANCELLED = 5;
    const DELIVERED = 6;


    public static function getList()
    {
        return [
            OrderStatus::SUBMITTED    => trans("submitted"),
            OrderStatus::ASSIGNED    => trans("assigned"),
            //OrderStatus::PENDING_PACKING => trans("pending_packing"),
            //OrderStatus::PENDING_SHIPPING => trans("pending_shipping"),
            OrderStatus::CANCELLED => trans("cancelled"),
            OrderStatus::DELIVERED => trans("delivered"),
        ];
    }

    public static function getValue($key)
    {
        $list = self::getList();

        return isset($list[$key]) ? $list[$key] : '';
    }
}
