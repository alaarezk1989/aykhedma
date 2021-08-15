<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Services\UserService;
use App\Models\User;
use App\Models\Group;
use View;
use Illuminate\Http\Request;

class UserGroupsController extends BaseController
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(User $user)
    {
        $this->authorize("userGroupsIndex", User::class);
        $groups = Group::where('active', '=', 1)->where('type', 0)->get();
        return View::make('admin.users.groups', ['groups' => $groups, 'user' => $user]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        $this->userService->fillUserGroupsFromRequest($request, $user);
        return redirect()->back()->with('success', trans('item_updated_successfully'));
    }
}
