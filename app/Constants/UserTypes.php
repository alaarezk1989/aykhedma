<?php

namespace App\Constants;

final class UserTypes
{
    const NORMAL = 1;
    const ADMIN  = 2;
    const VENDOR = 3;
    const DRIVER = 4;
    const PUBLIC_DRIVER = 5;
    const DELIVERY_PERSONAL = 6;

    public static function getList()
    {
        return [
            UserTypes::NORMAL => trans("client"),
            UserTypes::ADMIN => trans("admin"),
            UserTypes::VENDOR => trans("vendor"),
            UserTypes::DRIVER => trans("driver"),
            UserTypes::PUBLIC_DRIVER => trans("public_driver"),
            UserTypes::DELIVERY_PERSONAL => trans("delivery_personal"),
        ];
    }

    public static function getVendorTypes()
    {
        return[
            UserTypes::VENDOR => trans("vendor"),
            UserTypes::DRIVER => trans("driver"),

        ];
    }

    public static function getTypesUrl()
    {
        return [
            UserTypes::ADMIN => "admin",
            UserTypes::VENDOR => "vendor",
        ];
    }
    public static function getOneTypesUrl($index = '')
    {
        $list = self::getTypesUrl();
        $listOne = 'admin';
        if ($index) {
            $listOne = $list[$index];
        }
        return $listOne;
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
