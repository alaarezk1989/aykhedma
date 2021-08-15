<?php

namespace App\Constants;

final class PaymentTypes
{

    const CASH_OND_DELIVERY = 1 ;
    const ONLINE_PAYMENT   = 2 ;
    const SETTLE   = 3 ;

    public static function getList()
    {
        return [
            PaymentTypes::CASH_OND_DELIVERY =>trans("cash_on_delivery") ,
            PaymentTypes::ONLINE_PAYMENT => trans("online_payment"),
            PaymentTypes::SETTLE => trans("settle"),
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
