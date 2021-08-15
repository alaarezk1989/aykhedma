<?php

namespace App\Http\Controllers\Api\Driver;

use App\Models\Order;
use App\Models\User;
use App\Models\DriverOrders;
use App\Repositories\CancelReasonRepository;
use App\Repositories\OrderRepository;
use Illuminate\Routing\Controller;
use App\Http\Services\OrderService;
use App\Http\Requests\Api\OrderRequest;
use App\Constants\DriverOrderStatus ;
use App\Constants\OrderStatus ;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Requests\Api\Driver\DriverCancelRequest;

class OrdersController extends Controller
{
    protected $orderService;
    protected $orderRepository;
    protected $cancelReasonRepository;

    public function __construct(OrderService $orderService, OrderRepository $orderRepository, CancelReasonRepository $cancelReasonRepository)
    {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->cancelReasonRepository = $cancelReasonRepository;
    }

    public function driverOrders(Request $request)
    {
        $orders = $this->orderRepository->driverOrders($request)->paginate(10);

        return response()->json(["success"=>true, "result"=>$orders]);
    }

    public function contributorOrders(Request $request)
    {
        $orders = $this->orderRepository->contributorOrders($request)->paginate(10);

        return response()->json(["success" => true, "result"=>$orders]);
    }

    public function statuses()
    {
        $list = OrderStatus::getList();

        return response()->json(['success'=>true, 'result' => [$list]]);
    }

    public function products(Order $order)
    {
        $products = $this->orderRepository->products($order)->get();

        return response()->json(["success" => true, "result" =>$products]);
    }

    public function accept(Order $order)
    {
        if ($this->orderService->accept($order)) {
            return response()->json(['success' => true, 'result' => trans('driver_accept_successfully') ]);
        }
        return response()->json(['success' => false, 'result' => trans('not_accept_order')]);
    }

    public function cancel(Order $order, DriverCancelRequest $request)
    {
        if ($this->orderService->cancel($order, $request)) {
            return response()->json(['success' => true, 'result' => trans('order_cancelled_successfully')]);
        }

        return response()->json(['success' => false, 'result' => trans('not_cancel_order')]);
    }

    public function confirm(Order $order)
    {
        if ($this->orderService->confirm($order)) {
            return response()->json(['success' => true, 'result' => trans('order_delivered_successfully')]);
        }
        return response()->json(['success' => false, 'result' => trans('not_delivered_order')]);
    }

    public function cancelReasonsList()
    {
        $list = $this->cancelReasonRepository->search(request())->get();

        return response()->json(["success"=>true, "result" => $list]);
    }
}
