<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\VendorRequest;
use App\Http\Services\UploaderService;
use App\Http\Services\VendorService;
use App\Models\Vendor;
use App\Models\Activity;
use App\Constants\VendorTypes;
use App\Repositories\VendorRepository;
use View;

class VendorsController extends BaseController
{
    protected $vendorService;
    protected $vendorRepository;
    private $uploaderService;

    public function __construct(VendorService $vendorService, VendorRepository $vendorRepository, UploaderService $uploaderService)
    {
        $this->authorizeResource(Vendor::class, "vendor");
        $this->vendorService = $vendorService;
        $this->vendorRepository = $vendorRepository;
        $this->uploaderService = $uploaderService;
    }

    public function index()
    {
        $this->authorize("index", Vendor::class);
        $list = $this->vendorRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        $count = $this->vendorRepository->search(request())->count();
        $types = VendorTypes::getList();

        return View::make('admin.vendors.index', ['list' => $list, 'types' => $types, 'count' => $count]);
    }

    public function create()
    {
        $activities = Activity::all();
        $types = VendorTypes::getList();
        return View::make('admin.vendors.new', ['activities' => $activities, 'types' => $types]);
    }

    public function store(VendorRequest $request)
    {
        $this->vendorService->fillFromRequest($request);

        return redirect(route('admin.vendors.index'))->with('success', trans('vendor_added_successfully'));
    }

    public function destroy(Vendor $vendor)
    {
        if (count($vendor->branches)) {
            return redirect()->back()->with('danger', trans('cant_delete_this_item_related_with_branches'));
        }

        $this->uploaderService->deleteFile($vendor->logo);
        $vendor->delete();

        return redirect()->back()->with('success', trans('vendor_deleted_successfully'));
    }

    public function edit(Vendor $vendor)
    {
        $activities = Activity::all();
        $types = VendorTypes::getList();
        return View::make('admin.vendors.edit', ['vendor' => $vendor, 'activities' => $activities, 'types' => $types]);
    }

    public function update(VendorRequest $request, Vendor $vendor)
    {
        $this->vendorService->fillFromRequest($request, $vendor);

        return redirect(route('admin.vendors.index'))->with('success', trans('vendor_updated_successfully'));
    }

    public function export()
    {
        return $this->vendorService->export();
    }
}
