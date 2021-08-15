<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Group;
use App\Models\Permission;
use App\Models\GroupPermission;
use Illuminate\Http\Request;
use App\Http\Services\GroupPermissionService;
use View;

class GroupPermissionController extends BaseController
{
    protected $groupPermissionService;

    public function __construct(GroupPermissionService $groupPermissionService)
    {
        $this->authorizeResource(GroupPermission::class, "groupPermission");
        $this->groupPermissionService = $groupPermissionService;
    }

    public function index(Group $group)
    {
        $this->authorize("index", GroupPermission::class);

        $permissions = Permission::where('active', 1);

        $group->id == 2 ? $permissions = $permissions->where('type', 1)->get() : $permissions = $permissions->where('type', 0)->get();

        return View::make('admin.groups.permissions', ['permissions' => $permissions, 'group' => $group]);
    }

    public function store(Request $request, Group $group)
    {
        $this->groupPermissionService->fillFromRequest($request, $group);
        return redirect()->back()->with('success', trans('item_updated_successfully'));
    }
}
