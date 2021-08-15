<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Vendor\BranchZonesRequest;
use App\Http\Services\BranchService;
use App\Models\Branch;
use App\Models\BranchZone;
use App\Models\Location;
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
        $list = $branch->zones;
        return View::make('vendor.branches.zones.index', ['list' => $list,'branch'=>$branch]);
    }

    public function create(Branch $branch)
    {
        $locations = Location::all();
        return View::make('vendor.branches.zones.new', ['branch' => $branch,'locations'=>$locations]);
    }

    public function store(BranchZonesRequest $request, Branch $branch)
    {
        $this->branchService->fillBranchZonesFromRequest($request);
        return redirect(route('vendor.branch.zones.index', ['branch' => $branch->id]))->with('success', trans('branch_zone_added_successfully'));
    }

    public function destroy(Branch $branch, BranchZone $branchZone)
    {
        $branchZone->delete();
        return redirect()->back()->with('success', trans('branch_zone_deleted_successfully'));
    }

    public function edit(Branch $branch, BranchZone $branchZone)
    {
        $locations = Location::all();
        return View::make('vendor.branches.zones.edit', ['branch' => $branch , 'branchZone' => $branchZone,'locations'=>$locations]);
    }

    public function update(BranchZonesRequest $request, Branch $branch, BranchZone $branchZone)
    {
        $this->branchService->fillBranchZonesFromRequest($request, $branchZone);
        return redirect(route('vendor.branch.zones.index', ['branch' => $branchZone->branch_id]))->with('success', trans('branch_zone_updated_successfully'));
    }
}
