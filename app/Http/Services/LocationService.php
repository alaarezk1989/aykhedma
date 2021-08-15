<?php

namespace App\Http\Services;

use App\Models\Location;
use Symfony\Component\HttpFoundation\Request;

class LocationService
{
    public function fillFromRequest(Request $request, $location = null)
    {
        if (!$location) {
            $location = new Location();
        }

        $location->fill($request->request->all());
        $location->active = $request->request->get('active', 0);

        if ($request->filled('city_id')) {
            $location->parent_id = $request->get('city_id');
        }
        if ($request->filled('region_id') && $request->filled('city_id')) {
            $location->parent_id = $request->get('region_id');
        }

        $location->save();

        return $location;
    }

    public function checkLocationHasAddress($location)
    {
        if (count($location->addresses)) {
            return true;
        }

        if (count($location->children)) {
            foreach ($location->children as $child) {
                if (count($child->addresses)) {
                    return true;
                }
                if(count($child->children)) {
                    foreach ($child->children as $leave) {
                        if (count($leave->addresses)) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    public function checkLocationHasBranches($location)
    {
        if (count($location->branches)) {
            return true;
        }

        if (count($location->children)) {
            foreach ($location->children as $child) {
                if (count($child->branches)) {
                    return true;
                }
                if(count($child->children)) {
                    foreach ($child->children as $leave) {
                        if (count($leave->branches)) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
