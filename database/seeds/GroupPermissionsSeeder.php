<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class GroupPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::where('type', 0)->get();

        foreach ($permissions as $permission) {
            DB::table('group_permissions')->insert([
                'group_id' => 1,
                'permission_id' => $permission->id,
            ]);
        }
    }
}
