<?php

namespace App\Constants;

final class PromotionTypes
{
    const FIXED    = 1;
    const PERCENTAGE    = 2;

    public static function getList()
    {
        return [
            PromotionTypes::FIXED   => trans("fixed"),
            PromotionTypes::PERCENTAGE   => trans("percentage"),
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
