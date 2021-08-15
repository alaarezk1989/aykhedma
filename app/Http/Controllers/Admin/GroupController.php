<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Repositories\GroupRepository;
use App\Http\Requests\Admin\GroupRequest;
use App\Http\Services\GroupService;
use App\Http\Services\GroupPermissionService;
use Illuminate\Routing\Controller;
use View;

class GroupController extends BaseController
{

    protected $groupService;
    protected $groupPermissionService;
    protected $groupRepository;

    public function __construct(GroupService $groupService, GroupPermissionService $groupPermissionService, GroupRepository $groupRepository)
    {
        $this->authorizeResource(Group::class, "group");

        $this->groupService = $groupService;
        $this->groupPermissionService = $groupPermissionService;
        $this->groupRepository = $groupRepository;
    }

    public function index()
    {
        $this->authorize("index", Group::class);

        $list = $this->groupRepository->search(request())->paginate(10);

        $list->appends(request()->all());
        return View::make('admin.groups.index', ['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $this->groupService->fillFromRequest($request);
        return redirect(route('admin.groups.index'))->with('success', trans('item_added_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return View::make('admin.groups.edit', ['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupRequest $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, Group $group)
    {
        $this->groupService->fillFromRequest($request, $group);
        return redirect(route('admin.groups.index'))->with('success', trans('item_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }
}
