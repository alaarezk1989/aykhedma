<?php

namespace App\Http\Controllers\Api;

use App\Constants\UserTypes;
use App\Http\Requests\Api\ProfileRequest;
use App\Http\Services\NotificationService;
use App\Http\Requests\Api\UserDevicesRequest;
use App\Http\Requests\Api\UploadPictureRequest;
use App\Http\Services\UserService;
use App\Models\UserDevice;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{
    protected $userService;
    protected $notificationService;
    protected $userRepository;

    public function __construct(UserService $userService, NotificationService $notificationService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
    }

    public function storeUserDevice(UserDevicesRequest $request)
    {
        if (!$userDevice = UserDevice::where('token', $request->request->get('token'))->first()) {
            $userDevice = $this->userService->fillUserDeviceFromRequest($request);
        }

        return response()->json($userDevice);
    }

    public function destroyUserDevice($token)
    {
        if ($device = UserDevice::where('token', $token)->first()) {
            UserDevice::destroy($device->id);
        }

        return response()->json([]);
    }
    
    public function updateProfile(ProfileRequest $request)
    {
        $this->userService->updateProfile($request);

        return response(['success' => true], Response::HTTP_CREATED);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendPhoneVerified()
    {
        $this->userService->resetPhoneVerified();
        $this->notificationService->sendSMS(auth()->user(), auth()->user()->phone_verify);
        return response()->json(auth()->user())
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyPhone(Request $request)
    {
        try {
            $this->userService->verifyUserPhone($request);
        } catch (\Exception $e) {
            return response()->json($e->getMessage())
                ->setStatusCode($e->getCode());
        }
        return response()->json(auth()->user())
            ->setStatusCode(Response::HTTP_OK);
    }

    public function types()
    {
        $userTypes = UserTypes::getList();

        return response()->json($userTypes, 200);
    }

    public function points()
    {
        $balance = $this->userRepository->getPointsBalance(auth()->user()->id);

        return response()->json(['result' => $balance]);
    }

    public function uploadProfile(UploadPictureRequest $request)
    {
        $path = $this->userService->uploadProfilePicture($request);
        if ($path) {
            return response()->json(['success'=>true, 'result'=> $path]);
        }

        return response()->json(['success'=>false, 'result' => trans('failed_upload_profile_picture')]);
    }
}
