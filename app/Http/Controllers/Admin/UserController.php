<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ClassTypes;
use App\Constants\UserTypes;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Services\UploaderService;
use App\Http\Services\UserService;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Branch;
use App\Repositories\UserRepository;
use View;

class UserController extends BaseController
{
    protected $userService;
    private $userRepository;
    private $uploaderService;

    public function __construct(UserService $userService, UserRepository $userRepository, UploaderService $uploaderService)
    {
        $this->authorizeResource(User::class, "user");
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->uploaderService = $uploaderService;
    }

    public function index()
    {
        $this->authorize("index", User::class);
        $list = $this->userRepository->search(request())->paginate(10);
        $list->appends(request()->all());

        $count = $this->userRepository->search(request())->count();
        $types = UserTypes::getList();
        $classes = ClassTypes::getList();
        $companies = Company::all();

        return View::make('admin.users.index', ['list' => $list, 'count' => $count, 'types' => $types, 'classes' => $classes, 'companies' => $companies]);
    }

    public function create()
    {
        $vendors = Vendor::where('active', 1)->get();
        $branches = Branch::where('active', 1)->get();
        $companies = Company::all();

        return View::make('admin.users.create', ['vendors' => $vendors, 'companies' => $companies, 'branches' => $branches]);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->fillFromRequest($request);

        if ($user->type == UserTypes::NORMAL){
            return redirect(route('admin.user.addresses.create', ['user' => $user->id]))->with('success', trans('item_added_successfully'));
        }

        return redirect(route('admin.users.index'))->with('success', trans('item_added_successfully'));
    }

    public function edit(User $user)
    {
        $vendors = Vendor::where('active', 1)->get();
        $companies = Company::all();
        $branches = Branch::where('vendor_id', $user->vendor_id)->get();
        $allBranches = Branch::where('active', 1)->get();

        $userBranchesPermissions = [];
        foreach ($user->branchesPermission as $branchPermission) {
            $userBranchesPermissions[] = $branchPermission->permissible_id;
        }

        request()->request->add(['branches' => $userBranchesPermissions]);

        return View::make('admin.users.edit', ['user' => $user, 'vendors' => $vendors, 'companies' => $companies, 'branches'=>$branches, 'branchesPermissions'=>$allBranches, 'userBranchesPermissions' => $userBranchesPermissions]);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->userService->fillFromRequest($request, $user);
        return redirect(route('admin.users.index'))->with('success', trans('item_updated_successfully'));
    }

    public function destroy(User $user)
    {
        if (in_array($user->id, [1, 2])) {
            return redirect()->back()->with('danger', trans('cant_delete_this_user'));
        }
        $this->uploaderService->deleteFile($user->image);
        $user->delete();

        return redirect()->back()->with('success', 'Item Deleted Successfully');
    }

    public function export()
    {
        return $this->userService->export();
    }
}
