<?php

namespace App\Constants;

final class BannerTypes
{
    const GLOBAL = 1;
    const  BRANCH_BANNER = 2;

    public static function getList()
    {
        return [
            BannerTypes::GLOBAL    => trans("global"),
            BannerTypes::BRANCH_BANNER => trans("branch_banner"),
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
