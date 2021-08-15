<?php

namespace App\Http\Controllers\Vendor;

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
     */
    public function index(User $user)
    {
        $groups = Group::where('active', '=', 1)->where('type', 1)->get();
        return View::make('vendor.staff.groups', ['groups' => $groups, 'user' => $user]);
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
