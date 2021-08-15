<?php

namespace App\Repositories;

use App\Constants\DriverOrderStatus;
use App\Constants\OrderStatus;
use App\Constants\UserTypes;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Permissible;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;

class OrderRepository
{
    public function search(Request $request)
    {
        $orders = Order::query()->orderByDesc("id");

        if ($request->filled('branch_id')) {
            $orders->where('branch_id', $request->get('branch_id'));
        }
        if ($request->filled('vendor_id')) {
            $orders->whereHas('branch.vendor', function ($query) use ($request) {
                $query->where('id', $request->query->get('vendor_id'));
            });
        }
        if ($request->filled('driver_id')) {
            $orders->where('driver_id', $request->get('driver_id'));
        }
        if ($request->get('status') && !empty($request->get('status'))) {
            $orders->where('status', $request->query->get('status'));
        }
        if ($request->get('payment_type') && !empty($request->get('payment_type'))) {
            $orders->where('payment_type', $request->query->get('payment_type'));
        }
        if ($request->get('type') && !empty($request->get('type'))) {
            $orders->whereHas('branch', function ($query) use ($request) {
                $query->where('type', $request->query->get('type'));
            });
        }
        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $orders->where('created_at', '>=', $request->get('from_date'));
        }
        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $orders->where('created_at', '<=', $request->get('to_date'));
        }
        if ($request->filled('company')) {
            $orders->whereHas('voucher.company', function ($query) use ($request) {
                $query->where('id', $request->query->get('company'));
            });
        }

        if (Permissible::where('user_id', auth()->user()->id)->where('permissible_type', 'App\Models\Branch')->first()) {
            $orders->whereHas('branch.permissible', function ($query) {
                $query->where('user_id', auth()->user()->id);
            });
        }

        return $orders;
    }

    public function products($order)
    {
        return Order::with(['products','products.product','products.product.images', 'shipment', 'address', 'user', 'branch', 'products.product.unit.translations'])
            ->where('id', $order->id)
            ->orderBy("id", "DESC");
    }

    public function driverOrders(Request $request)
    {
        $orders = Order::with(['address', 'branch', 'shipment']);

        if ($request->get('status') == 'previous') {
            $orders->where('driver_id', auth()->user()->id);
            $orders->whereIn('status', [OrderStatus::CANCELLED, OrderStatus::DELIVERED]);
        }
        if ($request->get('status') == 'current') {
            $orders->where('driver_id', auth()->user()->id);
            $orders->where('status', OrderStatus::ASSIGNED);
            $orders->whereHas('drivers', function ($query) {
                $query->where('status', DriverOrderStatus::DRIVER_ACCEPT);
            });
        }
        if ($request->get('status') == 'new') {
            if (auth()->user()->type != UserTypes::PUBLIC_DRIVER) {
                $orders->where('driver_id', auth()->user()->id);
                $orders->where('status', OrderStatus::ASSIGNED);
                $orders->whereHas('drivers', function ($query) {
                    $query->whereNotIn('status', [DriverOrderStatus::DRIVER_ACCEPT, DriverOrderStatus::DRIVER_CANCELED]);
                });
            } else {
                $branches = auth()->user()->publicDriverBranches->map(function ($list) {
                    return collect($list->toArray())
                        ->only(['id'])
                        ->all();
                });
                $branchesIds = array_column($branches->toArray(), 'id');

                $orders->where('driver_id', null);
                $orders->where('status', OrderStatus::SUBMITTED);
                $orders->whereIn('branch_id', $branchesIds);
            }
        }

        if (auth()->user()->type == UserTypes::DELIVERY_PERSONAL) {
            return $orders->orderBy('shipment_id', 'ASC');
        }

        return $orders->orderBy("id", "DESC");
    }

    public function contributorOrders(Request $request)
    {
        $orders = Order::with(['address','branch','drivers', 'shipment'])
            ->whereHas('branch.vendor', function ($query) {
                $query->where('vendor_id', auth()->user()->vendor_id);
            });

        if ($request->get('status') == 'new') {
            $orders->where('status', OrderStatus::SUBMITTED);
        }
        if ($request->get('status') == 'current') {
            $orders->whereNotIn('status', [OrderStatus::SUBMITTED, OrderStatus::CANCELLED, OrderStatus::DELIVERED]);
        }
        if ($request->get('status') == 'previous') {
            $orders->whereIn('status', [OrderStatus::CANCELLED, OrderStatus::DELIVERED]);
        }
        if ($request->filled('branch_id')) {
            $orders->where('branch_id', $request->get('branch_id'));
        }

        return $orders->orderBy('id', 'DESC') ;
    }

    public function checkPromotionCodeExists(Request $request)
    {
        $type = 'coupon';
        $promotion = Coupon::where('code', $request->get('code'))
           ->where('expire_date', '>=', Carbon::now())
           ->where('active', 1)->first();

        if (!$promotion) {
            $type = 'voucher';
            $promotion = Voucher::where('code', $request->get('code'))
                ->where('expire_date', '>=', Carbon::now())
                ->where('is_used', 0)
                ->where('active', 1)->first();
        }

        if ($promotion) {
            if ($promotion->vendor_id && $promotion->vendor_id != $request->get('vendor_id')) {
                return false;
            }
            if ($promotion->branch_id && $promotion->branch_id != $request->get('branch_id')) {
                return false;
            }
            if ($promotion->activity_id && $promotion->activity_id != $request->get('activity_id')) {
                return false;
            }

            if ($type == 'coupon') {
                $user = auth()->user()->whereHas('coupons', function ($query) use ($promotion) {
                    $query->where('coupon_id', $promotion->id);
                    $query->where('user_id', auth()->user()->id);
                })->get();

                if (!count($user)) {
                    return $promotion;
                }
            }
            if ($type == 'voucher') {
                return $promotion;
            }
        }

        return false;
    }
}
