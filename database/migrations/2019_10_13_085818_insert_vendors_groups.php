<?php

use App\Models\Group;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertVendorsGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $groups = [

            [
                "type" => "0",
                "active" => true,
                "ar" => [ "name" => "مدير" ],
                "en" => [ "name" => "Super Admin" ],
            ],
            [
                "type" => "0",
                "active" => true,
                "ar" => [ "name" => "بائع رئيسى" ],
                "en" => [ "name" => "Super Vendor" ],
            ],
            [
                "type" => "1",
                "active" => true,
                "ar" => [ "name" => "مدير الطلبات" ],
                "en" => [ "name" => "Orders Manager" ],
            ],
            [
                "type" => "1",
                "active" => true,
                "ar" => [ "name" => "مدير الأفروع" ],
                "en" => [ "name" => "Branches Manager" ],
            ],
            [
                "type" => "1",
                "active" => true,
                "ar" => [ "name" => "مدير الموظفين" ],
                "en" => [ "name" => "Staff Manager" ],
            ],
            [
                "type" => "1",
                "active" => true,
                "ar" => [ "name" => "مدير منتجات الأفروع" ],
                "en" => [ "name" => "Branch products manager" ],
            ],
            [
                "type" => "1",
                "active" => true,
                "ar" => [ "name" => "مدير منتجات الطلبات" ],
                "en" => [ "name" => "Order products manager" ],
            ],

        ];

        foreach ($groups as $group) {
            $groupObj = new Group($group);
            $groupObj->type = $group['type'] ;
            $groupObj->save();
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
