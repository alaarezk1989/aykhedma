<?php

namespace App\Constants;

final class VehicleTypes
{
    const BICYCLE       = 1;
    const MOTORCYCLE    = 2;
    const VAN           = 3;
    const TRUCK         = 4;

    public static function getList()
    {
        return [
            VehicleTypes::BICYCLE    => trans("bicycle"),
            VehicleTypes::MOTORCYCLE => trans("motorcycle"),
            VehicleTypes::VAN        => trans("van"),
            VehicleTypes::TRUCK      => trans("truck")
        ];
    }

    /**
     * @param string $index
     * @return mixed|string
     */
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
