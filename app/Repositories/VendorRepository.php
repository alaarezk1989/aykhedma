<?php

namespace App\Repositories;

use App\Models\Vendor;
use Symfony\Component\HttpFoundation\Request;

class VendorRepository
{
    /**
     * @param $request
     * @return $this|mixed
     */
    public function search(Request $request)
    {
        $vendors = Vendor::query()->orderByDesc("id")
            ->when($request->get('active'), function ($vendors) use ($request) {
                return $vendors->where('active', '=', $request->get('active'));
            });

        if ($request->get('filter_by') == "activity_id" && !empty($request->get('q'))) {
            $vendors->where($request->get('filter_by'), $request->get('q'));
        }
        if ($request->get('filter_by') == "name" && !empty($request->get('q'))) {
            $vendors->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('q') . '%');
            });
        }
        if ($request->get('filter_by') == "zone_id" && !empty($request->get('q'))) {
            $vendors->whereHas('branches.zones', function ($query) use ($request) {
                $query->where('zone_id', $request->query->get('q'));
            });
        }
        if ($request->has('type') && !empty($request->get('type'))) {
            $vendors->where('type', $request->get('type'));
        }
        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $vendors->where('created_at', '>=', $request->get('from_date'));
        }
        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $vendors->where('created_at', '<=', $request->get('to_date'));
        }

        return $vendors;
    }
}
