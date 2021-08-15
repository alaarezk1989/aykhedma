<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Requests\Api\Driver\AssignDriverRequest;
use App\Http\Requests\Api\Driver\AvailabilityRequest;
use App\Http\Requests\Api\Driver\NotificationRequest;
use App\Http\Services\ReviewService;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Services\OrderService;
use App\Http\Services\UserService;
use Symfony\Component\HttpFoundation\Response ;
use App\Http\Requests\Api\ContactRequest ;
use App\Http\Services\NotificationService ;

class DriverController extends Controller
{
    protected $userRepository;
    protected $orderService;
    protected $userService;
    protected $notificationService;
    protected $reviewService;

    public function __construct(UserRepository $userRepository, OrderService $orderService, UserService $userService, ReviewService $reviewService)
    {
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
        $this->userService = $userService;
        $this->reviewService = $reviewService;
    }

    public function profile()
    {
        $rate = 0;
        $user = User::where('id', auth()->user()->id)
                ->with(['branch.vendor'])
                ->first();

        if ($user->branch) {
            $rate = $this->reviewService->calculateRate($user->branch->vendor, 'vendor');
        }

        return response()->json(['user' => $user, 'store_rate' => $rate], 200);
    }

    public function drivers(Request $request)
    {
        $drivers = $this->userRepository->getVendorDrivers($request)->paginate(10);

        return response()->json(["success" => true, "result" => $drivers])->setStatusCode(Response::HTTP_OK);
    }

    public function assignDriver(AssignDriverRequest $request)
    {
        if ($this->orderService->assignDriver($request)) {
            return response()->json(['success' => true, 'result', trans('driver_assigned_successfully')]);
        }
        return response()->json(['success' => false, 'result' => trans('order_already_assigned')]);
    }

    public function available(AvailabilityRequest $request)
    {
        $this->userService->toggleAvailability($request);

        return response()->json(['success' => true, 'result' => trans('availability_updated_successfully')]);
    }

    public function notification(NotificationRequest $request)
    {
        $this->userService->toggleNotification($request);

        return response()->json(['success' => true, 'result' => trans('notification_updated_successfully')]);
    }

    public function contactUs(ContactRequest $request)
    {
        $this->userService->contactUs($request);
        return response()->json(['success' => trans('message_sent_successfully')]);
    }
}
