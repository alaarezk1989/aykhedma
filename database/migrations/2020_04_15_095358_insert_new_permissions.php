<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Permission;

class InsertNewPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            [
                "identifier" => "admin.cancelReasons.index",
                "active" => true,
                "type" => 0,
                "ar" => ["name" => "عرض سبب الالغاء"],
                "en" => ["name" => "list of cancel reasons"],
            ],
            [
                "identifier" => "admin.cancelReasons.create",
                "active" => true,
                "type" => 0,
                "ar" => ["name" => "انشاء سبب الغاء جديد"],
                "en" => ["name" => "create new cancel reasons"],
            ],
            [
                "identifier" => "admin.cancelReasons.update",
                "active" => true,
                "type" => 0,
                "ar" => ["name" => "تعديل سبب الالغاء"],
                "en" => ["name" => "update of cancel reasons"],
            ],
            [
                "identifier" => "admin.reports.quantity",
                "active" => true,
                "type" => 0,
                "ar" => [ "name" => "تقرير تحليل كميات" ],
                "en" => [ "name" => "Quantity Analysis Report" ],
            ]
        ];

        foreach ($permissions as $permission) {
            $permissionObj = new Permission($permission);
            $permissionObj->identifier = $permission['identifier'];
            $permissionObj->save();
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
