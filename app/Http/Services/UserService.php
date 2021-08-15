<?php

namespace App\Http\Services;

use App\Constants\UserTypes;
use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\Permissible;
use App\Models\User;
use App\Models\Address;
use App\Models\Point;
use App\Models\Contact;
use App\Models\UserDevice;
use App\Repositories\UserRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Hash;
use App\Http\Services\ExportService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;

class UserService
{

    /**
     * @var UploaderService
     */
    private $uploaderService;
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UploaderService $uploaderService
     */
    public function __construct(UploaderService $uploaderService, UserRepository $userRepository)
    {
        $this->uploaderService = $uploaderService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param null $user
     * @return User|null
     */
    public function fillFromRequest(Request $request, $user = null, $branchesPermission = null)
    {
        if (!$user) {
            $user = new User();
        }
        if ($request->get('password') == '') {
            $request->request->remove('password');
        }
        $user->fill($request->all());
        if ($request->filled('branch_id')) {
            $user->branch_id = $request->branch_id;
        }
        if ($request->hasFile('image')) {
            $user->image = $this->uploaderService->upload($request->file('image'), 'users');
        }
        $user->active = $request->input("active", 0);

        $user->save();

        if ($request->filled('branches')) {
            if ($request->get('type') == UserTypes::ADMIN) {
                Permissible::query()->where('user_id', $user->id)->where('permissible_type', 'App\Models\Branch')->delete();
                foreach ($request->get("branches") as $branch) {
                    $branchesPermission = new Permissible();
                    $request->request->add(['user_id' => $user->id]);
                    $branchesPermission->fill($request->request->all());
                    $permissible = Branch::find($branch);
                    $permissible->permissible()->save($branchesPermission);
                }
            }
            if ($request->get('type') == UserTypes::PUBLIC_DRIVER) {
                $user->publicDriverBranches()->sync($request->input("branches"));
            }
        }

        return $user;
    }


    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user) {
            throw new Exception('Exception message', Response::HTTP_UNAUTHORIZED);
        }

        if ($request->filled('password') && !Hash::check($request->input('password'), $user->password)) {
            throw new Exception(trans('please_enter_correct_password'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->fill($request->all());
        if ($request->hasFile('image')) {
            $this->uploaderService->deleteFile($user->image);
            $user->image = $this->uploaderService->upload($request->file('image'), 'users');
        }

        $user->save();

        return true;
    }

    /**
     * @param Request $request
     * @param null $user
     * @return bool
     */
    public function fillChangePasswordFromRequest(Request $request, $user = null)
    {
        if (!$user) {
            return false;
        }
        $currentPassword = $request->input('current_password');
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }
        $user->fill($request->all());
        $user->save();
        return true;
    }

    /**
     * @param Request $request
     * @param null $user
     * @return bool|null
     */
    public function fillUserGroupsFromRequest(Request $request, $user = null)
    {
        if (!$user) {
            return false;
        }
        $user->groups()->sync($request->input("groups"));
        return $user;
    }

    /**
     * @param Request $request
     * @param null $address
     *
     * @return Address|null
     */
    public function fillUserAddress(Request $request, $address = null)
    {
        if (!$address) {
            $address = new address();
        }

        $address->fill($request->request->all());

        if ($request->filled('region_id')) {
            $address->location_id = $request->get('region_id');
        }
        if ($request->filled('district_id')) {
            $address->location_id = $request->get('district_id');
        }
        $address->save();
        return $address;
    }

    public function fillUserDeviceFromRequest(Request $request, $userDevice = null)
    {
        if (!$userDevice) {
            $userDevice = new UserDevice();
        }

        $userDevice->fill($request->request->all());
        $userDevice->save();

        return $userDevice;
    }

    public function fillUserPoints(Request $request, $point = null)
    {
        if (!$point) {
            $point = new Point();
        }

        $balance = $this->userRepository->getPointsBalance($request->input("user_id"));

        $point->fill($request->all());

        $point->balance = $balance + $request->input("amount");

        $point->save();

        return $point;
    }

    public function toggleFavouriteProduct(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->favoritedProducts()->toggle($request->request->get("branch_product_id"));
    }

    public function export()
    {
        $headings = [
            [trans('users_list')],
            [
                '#',
                trans('first_name'),
                trans('last_name'),
                trans('email'),
                trans('phone')
            ]
        ];
        $list = $this->userRepository->search(request())->get(['id','first_name','last_name','email','phone']);

        return Excel::download(new ExportService($list, $headings), 'Users Report.xlsx');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function resetPhoneVerified()
    {
        $user = auth()->user();
        $user->phone_verify = code($numbers = 4, $type = 'digits');
        $user->save();
        return $user;
    }

    public function verifyUserPhone(Request $request)
    {
        $user = auth()->user();
        if ($user->phone_verify != $request->get("code")) {
            throw new Exception('Invalid Code', Response::HTTP_NOT_ACCEPTABLE);
        }
        $user->phone_verify = '';
        $user->active = true;
        $user->save();

        return true;
    }

    public function toggleAvailability(Request $request)
    {
        $user = auth()->user();
        $user->available = $request->get('available', 0);
        $user->save();

        return $user;
    }

    public function toggleNotification(Request $request)
    {
        $user = auth()->user();
        $user->notification = $request->get('notification', 0);
        $user->save();

        return $user;
    }

    public function contactUs(Request $request)
    {
        $contact = new Contact() ;
        $contact->email = $request->get('email');
        $contact->message = $request->get('message');
        $contact->save();
    }

    public function uploadProfilePicture(Request $request)
    {
        $user = auth()->user();

        if ($request->hasFile('image')) {
            $this->uploaderService->deleteFile($user->image);
            $user->image = $this->uploaderService->upload($request->file('image'), 'users');

            $user->save();
            return $user->image;
        }
        return false;
    }
}
