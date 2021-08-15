<?php

namespace App\Constants;

final class VendorTypes
{
    const RETAILER  = 1;
    const SUPPLIER  = 2;
    const HUB       = 3;

    public static function getList()
    {
        return [
            VendorTypes::RETAILER    => trans("retailer"),
            VendorTypes::SUPPLIER    => trans("supplier"),
            VendorTypes::HUB         => trans("hub"),
        ];
    }
    public static function getIndex($index)
    {
        $list = self::getList();
        $listOne = '';
        if ($index) {
            $listOne = $list[$index];
        }
        return $listOne;
    }

    public static function getTypeValue()
    {
        $values=[];
        foreach (VendorTypes::getList() as $key => $value) {
            $values[]=$key;
        }
        return $values;
    }
}
