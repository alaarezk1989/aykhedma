<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\UserDevicesRequest;
use App\Http\Services\UserService;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Routing\Redirector as RedirectorAlias;
use View;
use Illuminate\Http\Request;

class UserDevicesController extends BaseController
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->authorizeResource(UserDevice::class, "userDevice");
        $this->userService = $userService;
    }


    /**
     * Display a listing of the resource.
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(User $user)
    {
        $this->authorize("index", UserDevice::class);
        $list = $user->devices;
        return View::make('admin.users.devices.index', ['list' => $list, 'user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function create(User $user)
    {
        return View::make('admin.users.devices.new', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     * @param UserDevicesRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|RedirectorAlias
     */
    public function store(UserDevicesRequest $request, User $user)
    {
        $this->userService->fillUserDeviceFromRequest($request);
        return redirect(route('admin.user.devices.index', ['user' => $user->id]))
            ->with('success', trans('item_added_successfully'));
    }


    /**
     * @param User $user
     * @param UserDevice $userDevice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user, UserDevice $userDevice)
    {
        $userDevice->delete();
        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }
}
