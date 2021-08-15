<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings = [

            [
                "key" => "POINTS_ACQUIRED",
                "active" => true,
                "ar" => [ "value" => "10" ],
                "en" => [ "value" => "10" ],
            ],
            [
                "key" => "POINTS_REDEEM",
                "active" => true,
                "ar" => [ "value" => "100" ],
                "en" => [ "value" => "100" ],
            ],
            [
                "key" => 'MIN_POINTS_FACTOR',
                "active" => true,
                "ar" => [ "value" => "50"],
                "en" => [ "value" => "50"],
            ],
            [
                "key" => 'VISA_CHARGE',
                "active" => true,
                "ar" => [ "value" => "3"],
                "en" => [ "value" => "2"],
            ],
            [
                "key" => 'VISA_CANCELLATION_CHARGE',
                "active" => true,
                "ar" => [ "value" => "1"],
                "en" => [ "value" => "1"],
            ],

        ];

        foreach ($settings as $setting) {
            $settingObj = new Setting($setting);
            $settingObj->key = $setting['key'] ;
            $settingObj->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
