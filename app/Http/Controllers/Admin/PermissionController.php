<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Services\PermissionService;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;

class PermissionController extends BaseController
{

    protected $permissionService;
    protected $permissionRepository;

    public function __construct(PermissionService $permissionService, PermissionRepository $permissionRepository)
    {
        $this->authorizeResource(Permission::class, "permission");
        $this->permissionService = $permissionService;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("index", Permission::class);

        $list = $this->permissionRepository->search(request())->paginate(10);

        $list->appends(request()->all());

        return View::make('admin.permissions.index', ['list' => $list]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return View::make('admin.permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $this->permissionService->fillFromRequest($request, $permission);
        return redirect(route('admin.permissions.index'))->with('success', trans('item_updated_successfully'));
    }

}
