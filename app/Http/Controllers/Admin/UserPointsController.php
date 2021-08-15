<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\UserPointsRequest;
use App\Http\Services\UserService;
use App\Models\User;
use View;

class UserPointsController extends BaseController
{
    private $userService;

    /**
     * UserPointsController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(User $user)
    {
        $list = $user->points;
        return View::make('admin.users.points.index', ['list' => $list,'user'=>$user]);
    }

    public function create(User $user)
    {
        return View::make('admin.users.points.new', ['user' => $user]);
    }

    public function store(UserPointsRequest $request, User $user)
    {
        $this->userService->fillUserPoints($request);
        return redirect(route('admin.user.points.index', ['user' => $user->id]))->with('success', trans('user_point_added_successfully'));
    }
}
