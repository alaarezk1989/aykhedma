<?php

use App\Models\GroupPermission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertVendorGroupsPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $groupsPermissions = [

            [
                "group_id" => 3,
                "permission_id" => 131,

            ],
            [
                "group_id" => 3,
                "permission_id" => 132,

            ],
            [
                "group_id" => 3,
                "permission_id" => 133,

            ],
            [
                "group_id" => 3,
                "permission_id" => 134,

            ],
            [
                "group_id" => 4,
                "permission_id" => 139,

            ],
            [
                "group_id" => 4,
                "permission_id" => 140,

            ],
            [
                "group_id" => 4,
                "permission_id" => 141,

            ],
            [
                "group_id" => 4,
                "permission_id" => 142,

            ],
            [
                "group_id" => 5,
                "permission_id" => 127,

            ],
            [
                "group_id" => 5,
                "permission_id" => 128,

            ],
            [
                "group_id" => 5,
                "permission_id" => 129,

            ],
            [
                "group_id" => 5,
                "permission_id" => 130,

            ],
            [
                "group_id" => 6,
                "permission_id" => 143,

            ],
            [
                "group_id" => 6,
                "permission_id" => 144,

            ],
            [
                "group_id" => 6,
                "permission_id" => 145,

            ],
            [
                "group_id" => 6,
                "permission_id" => 146,

            ],
            [
                "group_id" => 7,
                "permission_id" => 135,

            ],
            [
                "group_id" => 7,
                "permission_id" => 136,

            ],
            [
                "group_id" => 7,
                "permission_id" => 137,

            ],
            [
                "group_id" => 7,
                "permission_id" => 138,

            ],
            [
                "group_id" => 2,
                "permission_id" => 131,

            ],
            [
                "group_id" => 2,
                "permission_id" => 132,

            ],
            [
                "group_id" => 2,
                "permission_id" => 133,

            ],
            [
                "group_id" => 2,
                "permission_id" => 134,

            ],
            [
                "group_id" => 2,
                "permission_id" => 139,

            ],
            [
                "group_id" => 2,
                "permission_id" => 140,

            ],
            [
                "group_id" => 2,
                "permission_id" => 141,

            ],
            [
                "group_id" => 2,
                "permission_id" => 142,

            ],
            [
                "group_id" => 2,
                "permission_id" => 127,

            ],
            [
                "group_id" => 2,
                "permission_id" => 128,

            ],
            [
                "group_id" => 2,
                "permission_id" => 129,

            ],
            [
                "group_id" => 2,
                "permission_id" => 130,

            ],
            [
                "group_id" => 2,
                "permission_id" => 143,

            ],
            [
                "group_id" => 2,
                "permission_id" => 144,

            ],
            [
                "group_id" => 2,
                "permission_id" => 145,

            ],
            [
                "group_id" => 2,
                "permission_id" => 146,

            ],
            [
                "group_id" => 2,
                "permission_id" => 135,

            ],
            [
                "group_id" => 2,
                "permission_id" => 136,

            ],
            [
                "group_id" => 2,
                "permission_id" => 137,

            ],
            [
                "group_id" => 2,
                "permission_id" => 138,

            ],
        ];

        foreach ($groupsPermissions as $groupsPermission) {
            $groupsPermissionObj = new GroupPermission($groupsPermission);
            //$groupsPermissionObj->type = $groupsPermission['type'] ;
            $groupsPermissionObj->save();
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
