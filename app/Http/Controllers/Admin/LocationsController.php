<?php

namespace App\Http\Controllers\Admin;
use App\Http\Admin\Requests\LocationRequest;
use App\Http\Controllers\BaseController;
use App\Http\Services\LocationService;
use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use View;

class LocationsController extends BaseController
{

    protected $locationService;
    private $locationRepository;

    public function __construct(LocationService $LocationService, LocationRepository $locationRepository)
    {
        $this->authorizeResource(Location::class, "location");
        $this->locationService = $LocationService;
        $this->locationRepository = $locationRepository;
    }

    public function index(Request $request)
    {
        $this->authorize("index", Location::class);
        $list = $this->locationRepository->search(request());

        if ($request->query->get('view') == 'tree') {
            return View::make('admin.locations.tree', [
                'all' => $list->get(),
                'list' => $list->where('parent_id', '=', null)->get(),
            ]);
        }

        $list = $list->paginate(10);

        $list->appends(request()->all());

        return View::make('admin.locations.index', ['list' => $list]);
    }

    public function create()
    {
        $locations = Location::where('active', true)->where('parent_id', null)->get();

        $regions = [];
        if (old('city_id')) {
            $regions = Location::where('active', true)->where('parent_id', old('city_id'))->get();
        }

        return View::make('admin.locations.new', ['locations' => $locations, 'regions' => $regions]);
    }

    public function store(LocationRequest $request)
    {
        $this->locationService->fillFromRequest($request);
        return redirect(route('admin.locations.index'))->with('success', trans('item_added_successfully'));
    }

    public function destroy(Location $location)
    {
        if ($this->locationService->checkLocationHasAddress($location)) {
            return redirect()->back()->with('danger', trans('cant_delete_this_item_related_with_user_addresses'));
        }
        if ($this->locationService->checkLocationHasBranches($location)) {
            return redirect()->back()->with('danger', trans('cant_delete_this_item_related_with_user_branches'));
        }

        die;
        $location->delete();

        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function edit(Location $location)
    {
        $locations = Location::where('active', true)->where('parent_id', null)->get();

        $selectedCity = '';
        if (Location::find($location->parent_id)) {
            $selectedCity = Location::find($location->parent_id)->id;
            if (Location::find($location->parent_id)->parent_id) {
                $selectedCity = Location::find($location->parent_id)->parent_id;
            }
        }

        $regions = [];
        if ($selectedCity) {
            $regions = Location::where('active', true)->where('parent_id', $selectedCity)->get();
        }

        $selectedRegion = $location->parent_id;

        return view('admin.locations.edit', ['item'=>$location, 'locations' => $locations, 'regions' => $regions, 'selectedCity' => $selectedCity, 'selectedRegion' => $selectedRegion]);
    }

    public function update(LocationRequest $request, Location $location)
    {
        $this->locationService->fillFromRequest($request, $location);
        return redirect(route('admin.locations.index'))->with('success', trans('item_updated_successfully'));
    }
}
