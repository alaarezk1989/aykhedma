<?php

namespace App\Constants;

final class DeliverySla
{
    const QUARTER_HOUR = "0.25";
    const HALF_HOUR = "0.5";
    const HOUR = "1.00";
    const HOUR_AND_HALF = "1.5";
    const TWO_HOURS = "2.00";
    const THREE_HOURS = "3.00";
    const FIVE_HOURS = "5.00";
    const TEN_HOURS = "10.00";
    const TWENTY_FOUR_HOUR = "24.00";
    const FORTY_EIGHT_HOUR = "48.00";
    const SEVENTY_TWO_HOUR = "72.00";
    const NINETY_SIX_HOUR = "96.00";
    const ONE_HUNDRED_AND_TWENTY_HOUR = "120.00";

    public static function getList()
    {
        return [
                DeliverySla::QUARTER_HOUR =>"1/4"." ". trans("hour"),
                DeliverySla::HALF_HOUR =>"1/2"." ". trans("hour"),
                DeliverySla::HOUR =>"1"." ". trans("hour"),
                DeliverySla::HOUR_AND_HALF =>"1.5"." ". trans("hour"),
                DeliverySla::TWO_HOURS =>"2"." ". trans("hours"),
                DeliverySla::THREE_HOURS =>"3"." ". trans("hours"),
                DeliverySla::FIVE_HOURS =>"5"." ". trans("hours"),
                DeliverySla::TEN_HOURS =>"10"." ". trans("hours"),
                DeliverySla::TWENTY_FOUR_HOUR =>"1"." ". trans("day"),
                DeliverySla::FORTY_EIGHT_HOUR =>"2"." ". trans("days"),
                DeliverySla::SEVENTY_TWO_HOUR =>"3"." ". trans("days"),
                DeliverySla::NINETY_SIX_HOUR =>"4"." ". trans("days"),
                DeliverySla::ONE_HUNDRED_AND_TWENTY_HOUR =>"5"." ". trans("days"),
        ];
    }
}

