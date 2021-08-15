<?php

namespace App\Constants;

final class PaymentStatus
{
    const DRAFT = 1;
    const CONFIRMED = 2;


    public static function getList()
    {
        return [
            PaymentStatus::DRAFT => trans("draft"),
            PaymentStatus::CONFIRMED => trans("confirmed"),
        ];
    }
}
