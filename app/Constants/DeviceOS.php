<?php

namespace App\Constants;

final class DeviceOS
{
    const WEB = 1;
    const ANDROID = 2;
    const IOS = 3;

    public static function getList()
    {
        return [
            DeviceOS::WEB => trans("web"),
            DeviceOS::ANDROID => trans("android"),
            DeviceOS::IOS => trans("ios"),
        ];
    }
}
