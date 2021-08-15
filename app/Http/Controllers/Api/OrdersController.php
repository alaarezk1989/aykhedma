<?php

namespace App\Http\Controllers\Api;

use App\Constants\OrderStatus;
use App\Http\Requests\Api\ValidatePromotionCodeRequest;
use App\Models\Order;
use Illuminate\Routing\Controller;
use App\Http\Services\OrderService;
use App\Http\Services\NotificationService;
use App\Http\Requests\Api\OrderRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(OrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->fillApiRequest($request);

        return response()->json($order);
    }

    public function index()
    {
        $orders = Order::with(['products','products.product','products.product.images','address','branch.zones'])
            ->where('user_id', auth()->user()->id)
            ->orderBy("created_at", "DESC")
            ->get();

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        $order = $order->with(['products','products.product','address','branch.zones'])
                ->find($order->id);

        return response()->json($order);
    }

    public function validatePromotionCode(ValidatePromotionCodeRequest $request)
    {
        $amountAfterDiscount = $this->orderService->validatePromotionCode($request);
        if ($amountAfterDiscount < 0) {
            return response()->json(['success' => false, 'result' => trans('not_enough_amount')." ". $amountAfterDiscount*-1 ]);
        }
        if (strpos($amountAfterDiscount, "voucher")) {
            return response()->json(['success' => false, 'result' => trans('amount_bigger_than_voucher')." ". str_replace('voucher', '', $amountAfterDiscount)]);
        }
        if ($amountAfterDiscount ===  false) {
            return response()->json(['success' => false, 'result' => trans('invalid_code')]);
        }
        if ($amountAfterDiscount >= 0) {
            return response()->json(['success' => true, 'result' => $amountAfterDiscount]);
        }

        return response()->json(['success' => false, 'result' => trans('invalid_code')]);
    }

    public function cancel(Order $order)
    {
        if ($this->orderService->cancelOrder($order)) {
            return response()->json(['success' => true, 'result' => trans('order_cancelled_successfully')]);
        }

        return response()->json(['success' => false, 'result' => trans('not_cancel_order')]);
    }

    public function validateMinimumOrderAmount(Request $request)
    {
        if ($this->orderService->validateOrderAmount($request)) {
            return response()->json(['success' => true, 'result' => trans('valid_order')]);
        }

        return response()->json(['success' => false, 'result' => trans('not_min_order_amount')]);
    }
}
