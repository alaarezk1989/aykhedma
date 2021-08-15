<?php

namespace App\Repositories;
use App\Models\Coupon;

class CouponRepository
{
    public function searchFromRequest($request)
    {
        $coupons = Coupon::orderBy('id', 'DESC');

        if ($request->get('filter_by') == "title" && !empty($request->get('q'))) {
            $coupons->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->query->get('q') . '%');
            });
        }
        if ($request->get('filter_by') == "value" && !empty($request->get('q'))) {
            $coupons->where($request->get('filter_by'), $request->get('q'));
        }
        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $coupons->where('expire_date', '>=', $request->get('from_date'));
        }
        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $coupons->where('expire_date', '<=', $request->get('to_date'));
        }

        return $coupons;
    }
}
