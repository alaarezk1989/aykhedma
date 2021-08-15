<?php

use App\Models\Location;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $locations = [
            [
                "active" => true,
                "long" => "30.2154885",
                "lat" => "32.21452",
                "parent_id" => null,
                "ar" => [ "name" => "مصر" ],
                "en" => [ "name" => "Egypt" ],
            ],
            [
                "active" => true,
                "long" => "30.32542",
                "lat" => "32.874632",
                "parent_id" => 1,
                "ar" => [ "name" => "القاهرة" ],
                "en" => [ "name" => "Cairo" ],
            ],
            [
                "active" => true,
                "long" => "30.2156545885",
                "lat" => "32.8943587",
                "parent_id" => 2,
                "ar" => [ "name" => "المعادى" ],
                "en" => [ "name" => "Maadi" ],
            ],
            [
                "active" => true,
                "long" => "30.215645885",
                "lat" => "32.56564",
                "parent_id" => 3,
                "ar" => [ "name" => "زهراء المعادى" ],
                "en" => [ "name" => "zahraa Maadi" ],
            ],
            [
                "active" => true,
                "long" => "30.35564",
                "lat" => "32.132564",
                "parent_id" => 1,
                "ar" => [ "name" => "الجيزة" ],
                "en" => [ "name" => "Giza" ],
            ],
            [
                "active" => true,
                "long" => "30.564564",
                "lat" => "32.327",
                "parent_id" => 5,
                "ar" => [ "name" => "الهرم" ],
                "en" => [ "name" => "El Haram" ],
            ],

        ];
        foreach ($locations as $location) {
            $locationObj = new Location($location);
            $locationObj->long = $location['long'] ;
            $locationObj->lat = $location['lat'] ;
            $locationObj->parent_id = $location['parent_id'] ;
            $locationObj->save();
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
