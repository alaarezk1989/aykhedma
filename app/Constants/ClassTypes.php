<?php

namespace App\Constants;

final class ClassTypes
{
    const A    = 1;
    const B    = 2;
    const C    = 3;

    public static function getList()
    {
        return [
            ClassTypes::A   => trans("a"),
            ClassTypes::B   => trans("b"),
            ClassTypes::C   => trans("c"),
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
