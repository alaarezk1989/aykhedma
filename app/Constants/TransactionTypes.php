<?php

namespace App\Constants;

final class TransactionTypes
{
    const COMMISSION = 1 ;
    const ONLINE_TRANSFER = 2 ;
    const PRODUCT_COST = 3 ;
    const DELIVERY_CHARGE = 4;
    const SETTLE = 5 ;

    public static function getList()
    {
        return [
            TransactionTypes::COMMISSION =>trans("commission") ,
            TransactionTypes::ONLINE_TRANSFER => trans("online_transfer"),
            TransactionTypes::PRODUCT_COST => trans("product_cost"),
            TransactionTypes::DELIVERY_CHARGE => trans("delivery_charge"),
            TransactionTypes::SETTLE => trans("settle"),
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
