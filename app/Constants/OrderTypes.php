<?php

namespace App\Constants;

final class OrderTypes
{

    const NORMAL = 1 ;
    const SHIPMENT   = 2 ;

    public static function getList()
    {
        return [
            OrderTypes::NORMAL =>trans("normal_order") ,
            OrderTypes::SHIPMENT => trans("shipment"),
        ];
    }

    public static function getOne($index = '')
    {
        $list = self::getList();
        $list_one = '';
        if ($index) {
            $list_one = $list[$index];
        }
        return $list_one;
    }
}
