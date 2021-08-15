<?php

namespace App\Constants;

final class BranchTypes
{

    const RETAILER  = 1;
    const SUPPLIER  = 2;
    const HUB       = 3;

    public static function getList()
    {
        return [
            BranchTypes::RETAILER    => trans("retailer"),
            BranchTypes::SUPPLIER    => trans("supplier"),
            BranchTypes::HUB         => trans("hub"),
        ];
    }
    public static function getTypeValue()
    {
        $values=[];
        foreach (BranchTypes::getList() as $key => $value) {
            $values[]=$key;
        }
        return $values;
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
}

