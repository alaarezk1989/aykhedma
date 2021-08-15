<?php

namespace App\Repositories;

use App\Models\Location;
use Symfony\Component\HttpFoundation\Request;
use DB;

class LocationRepository
{
    public function searchFromRequest($request)
    {
        $locations = Location::orderBy('id', 'DESC');

        if ($request->filled('city_id')) {
            $locations->where('parent_id', '=', $request->get('city_id'));
        }
        if ($request->filled('region_id')) {
            $locations->where('parent_id', '=', $request->get('region_id'));
        }
        if ($request->filled('active')) {
            $locations->where('active', '=', $request->get('active'));
        }
        if ($request->filled('parent')) {
            $locations->where('parent_id', '=', $request->get('parent'));
        }
        if ($request->filled('activity_id')) {
            $locations->whereHas('branches.vendor.activity', function ($query) use ($request) {
                $query->where('id', $request->get('activity_id'));
            });
        }

        return $locations;
    }

    public function search(Request $request)
    {
        $locations = Location::query()->orderByDesc("id");

        if ($request->has('name') && !empty($request->get('name'))) {
            $locations->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('name') . '%');
            });
        }

        return $locations;
    }

    public function nearestLocation(Request $request)
    {
        $location = DB::table("locations")
            ->select("locations.*", "name", DB::raw("6371 * acos(cos(radians(" . $request->input('lat') . "))
                * cos(radians(locations.lat))
                * cos(radians(locations.long) - radians(" . $request->input('long') . "))
                + sin(radians(" .$request->input('lat'). "))
                * sin(radians(locations.lat))) AS distance"))
            ->groupBy("locations.id", "name")
            ->join('locations_translations', 'locations_translations.location_id', '=', 'locations.id')
            ->where('active', 1)
            ->orderBy('distance', 'asc')
            ->limit(1);

        return $location;
    }
}
