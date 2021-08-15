<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

class LocationsController extends Controller
{
    protected $locationRepository;
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function index(Request $request)
    {
        $list = $this->locationRepository->searchFromRequest($request);
        if (!$request->query->get('flat', false)) {
            $list = $list->with('children.children');
        }

        if (!$request->filled('parent') && !$request->filled('activity_id') && !$request->filled('city_id') && !$request->filled('region_id')) {
            $list->where('parent_id', null);
        }

        return response()->json($list->with(['ancestors' => function ($q) {
            $q->where('active', 1);
        },'children'])->where('active', 1)->get());
    }

    public function show(Location $location)
    {
        return response()->json($location);
    }

    public function nearest(Request $request)
    {
        $location = $this->locationRepository->nearestLocation($request);

        return response()->json($location->get());
    }
}
