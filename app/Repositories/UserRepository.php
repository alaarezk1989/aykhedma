<?php

namespace App\Repositories;

use App\Models\Point;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use App\Constants\UserTypes  as UserTypes ;

class UserRepository
{
    public function getVendorUsers(Request $request)
    {
        $vendorUsers = User::query()
            ->where('vendor_id', auth()->user()->vendor_id)
            ->where('id', '!=', auth()->user()->id)
            ->orderByDesc("id");

        if ($request->has('type') && !empty($request->get('type'))) {
            $type = $request->get('type');
            $vendorUsers->where('vendor_id', '=', auth()->user()->vendor_id)
                ->when($type, function ($vendorUsers, $type) {
                    return $vendorUsers->where('type', '=', $type);
                });
        }
        if ($request->has('filter') && !empty($request->get('filter'))) {
            $vendorUsers->where($request->get('filter'), 'like', '%' . $request->query->get('q') . '%');
        }

        return $vendorUsers;
    }

    public function search(Request $request)
    {
        $users = User::query()->orderByDesc("id")

            ->when($request->get('name'), function ($users) use ($request) {
                return $users->where('first_name', 'like', '%' . $request->query->get('name') . '%')
                    ->orWhere('last_name', 'like', '%' . $request->query->get('name') . '%')
                    ;
            })
            ->when($request->get('company_id'), function ($users) use ($request) {
                return $users->where('company_id', '=', $request->query->get('company_id'));
            });

        if ($request->get('filter_by') == "name" && !empty($request->get('q'))) {
            $names = explode(" ", $request->query->get('q'));
            $users->WhereIn('first_name', $names);
            $users->orWhereIn('last_name', $names);
        }
        if ($request->get('filter_by') == "group_id" && !empty($request->get('q'))) {
            $users->whereHas('groups', function ($query) use ($request) {
                $query->where('id', $request->query->get('q'));
            });
        }
        if ($request->get('filter_by') == "location_id" && !empty($request->get('q'))) {
            $users->whereHas('addresses', function ($query) use ($request) {
                $query->where('location_id', $request->query->get('q'));
            });
        }
        if ($request->get('filter_by') == "category_id" && !empty($request->get('q'))) {
            $users->whereHas('orders.products', function ($query) use ($request) {
                $query->where('order_products.category_id', $request->query->get('q'));
            });
        }
        if ($request->get('type') && !empty($request->get('type'))) {
            $users->where('type', $request->query->get('type'));
        }
        if ($request->get('class') && !empty($request->get('class'))) {
            $users->where('class', $request->query->get('class'));
        }
        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $users->where('created_at', '>=', $request->get('from_date'));
        }
        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $users->where('created_at', '<=', $request->get('to_date'));
        }

        return $users;
    }

    public function admins()
    {
        $admins = User::where('type', UserTypes::ADMIN);

        return $admins;
    }

    public function getPointsBalance($user)
    {
        return Point::where('user_id', $user)->groupBy('user_id')->sum('amount');
    }

    public function getVendorDrivers(Request $request)
    {
        $drivers = User::where('type', UserTypes::DRIVER)
            ->where('vendor_id', auth()->user()->vendor_id)
            ->where('available', 1)
            ->where('active', 1);

        if ($request->filled('branch_id')) {
            $drivers->where('branch_id', $request->get('branch_id'));
        }

        return $drivers ;
    }
}
