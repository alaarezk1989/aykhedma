<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Models\Vendor;
use DB;

class SearchRepository
{
    public function searchFromRequest($request)
    {
        $activity = $request->input("activity");

        $branches = Branch::with('products')
                    ->whereHas('vendor', function ($query) use ($activity) {
                           $query->where('vendors.activity_id', $activity);
                    });

        return $branches;
    }

    public function searchCategoriesRequest($request)
    {
        $zone = $request->input('zone');

        $branches = Branch::select('branches.*', 'branch_zones.delivery_sla', 'branch_zones.delivery_fee', 'vendors.logo')
        ->with(['categories' => function ($query) {
            $query->distinct();
        },
        'zones' => function ($query) {
            $query->distinct();
        }
        ])
        ->leftJoin('vendors', 'branches.vendor_id', '=', 'vendors.id')
        ->rightJoin('branch_zones', function ($join) use ($zone) {
            $join->on('branches.id', '=', 'branch_zones.branch_id');
            $join->on('zone_id', '=', DB::raw("$zone"));
        })

        ->groupBy('vendors.id', 'branches.id', 'branch_zones.id')
        ->where('vendors.activity_id', $request->input("activity"))
        ->where('branch_zones.deleted_at', null)
        ->distinct();

        if ($request->has('order') && $request->get('order') == 'sla') {
            $branches->orderBy(DB::raw('ISNULL(delivery_sla), delivery_sla'), 'ASC');
        }
        if ($request->has('order') && $request->get('order') == 'rate') {
            $branches->withReviewableSum()->orderBy('reviewable_avg', 'DESC');
        }

        return $branches;
    }
}
