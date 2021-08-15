<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BranchZonesRequest;
use App\Http\Services\BranchService;
use App\Models\Branch;
use App\Models\BranchZone;
use App\Models\Location;
use Illuminate\Routing\Controller;
use View;

class BranchZonesController extends BaseController
{
    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function index(Branch $branch)
    {
        $this->authorize("index", [BranchZone::class, $branch]);
        $list = $branch->zones;
        return View::make('admin.branches.zones.index', ['list' => $list,'branch'=>$branch]);
    }

    public function create(Branch $branch)
    {
        $this->authorize("create", [BranchZone::class, $branch]);

        $locations = Location::where('active', true)->where('parent_id', null)->get();
        $regions = [];
        if (old('city_id')) {
            $regions = Location::where('active', true)->where('parent_id', old('city_id'))->get();
        }
        $districts = [];
        if (old('region_id')) {
            $districts = Location::where('active', true)->where('parent_id', old('region_id'))->get();
        }

        return View::make('admin.branches.zones.new', ['branch' => $branch,'locations'=>$locations, 'regions' => $regions, 'districts' => $districts]);
    }

    public function store(BranchZonesRequest $request, Branch $branch)
    {
        $this->branchService->fillBranchZonesFromRequest($request);
        return redirect(route('admin.branch.zones.index', ['branch' => $branch->id]))->with('success', trans('branch_zone_added_successfully'));
    }

    public function destroy(Branch $branch, BranchZone $branchZone)
    {
        $branchZone->delete();
        return redirect()->back()->with('success', trans('branch_zone_deleted_successfully'));
    }

    public function edit(Branch $branch, BranchZone $branchZone)
    {
        $this->authorize("update", [BranchZone::class, $branchZone, $branch]);

        $locations = Location::where('active', true)->where('parent_id', null)->get();
        $selectedCity = '';
        if (Location::find(Location::find($branchZone->zone_id)->parent_id)) {
            $selectedCity = Location::find(Location::find($branchZone->zone_id)->parent_id)->id;
            if (Location::find(Location::find($branchZone->zone_id)->parent_id)->parent_id) {
                $selectedCity = Location::find(Location::find($branchZone->zone_id)->parent_id)->parent_id;
            }
        }

        $regions = [];
        if ($selectedCity) {
            $regions = Location::where('active', true)->where('parent_id', $selectedCity)->get();
        }
        $selectedRegion = Location::find($branchZone->zone_id)->parent_id == $selectedCity ? $selectedRegion = Location::find($branchZone->zone_id)->id:Location::find($branchZone->zone_id)->parent_id;

        $districts = [];

        if ($selectedRegion) {
            $districts = Location::where('active', true)->where('parent_id', $selectedRegion)->get();
        }
        $selectedDistrict = Location::find($branchZone->zone_id)->id;

        if (Location::find($branchZone->zone_id)->parent_id == $selectedCity) {
            $selectedRegion = Location::find($branchZone->zone_id)->id;
            $selectedDistrict = '';
        }

        return View::make('admin.branches.zones.edit', ['branch' => $branch , 'branchZone' => $branchZone,'locations'=>$locations, 'regions' => $regions, 'districts' => $districts, 'selectedCity' => $selectedCity, 'selectedRegion' => $selectedRegion, 'selectedDistrict' => $selectedDistrict]);
    }

    public function update(BranchZonesRequest $request, Branch $branch, BranchZone $branchZone)
    {
        $this->authorize("delete", [BranchZone::class, $branchZone, $branch]);
        $this->branchService->fillBranchZonesFromRequest($request, $branchZone);
        return redirect(route('admin.branch.zones.index', ['branch' => $branchZone->branch_id]))->with('success', trans('branch_zone_updated_successfully'));
    }
}
