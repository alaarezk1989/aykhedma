<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OrderStatus;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BranchRequest;
use App\Http\Requests\Admin\BranchProductsRequest;
use App\Http\Requests\Admin\BranchZonesRequest;
use App\Http\Services\BranchService;
use App\Http\Services\ReviewService;
use App\Models\Branch;
use App\Models\Product;
use App\Models\BranchProduct;
use App\Models\BranchZone;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Location;
use App\Repositories\BranchRepository;
use App\Constants\BranchTypes ;
use App\Constants\UserTypes as UserTypes;
use Illuminate\Routing\Controller;
use View;


class BranchesController extends BaseController
{
    protected $branchService;
    protected $branchRepository;
    protected $reviewService;

    public function __construct(BranchService $branchService, BranchRepository $branchRepository, ReviewService $reviewService)
    {
        $this->authorizeResource(Branch::class, "branch");
        $this->branchService = $branchService;
        $this->branchRepository = $branchRepository;
        $this->reviewService = $reviewService;
    }

    public function index()
    {
        $this->authorize("index", Branch::class);
        $list = $this->branchRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        $count = $this->branchRepository->search(request())->count();
        $types = BranchTypes::getList() ;
        //$rate = $this->reviewService->calculateRate($vendor);

        return View::make('admin.branches.index', ['list' => $list, 'types'=>$types, 'count' => $count]);
    }

    public function create()
    {
        $types = BranchTypes::getList() ;
        $vendors = Vendor::where('active', 1)->get();
        return View::make('admin.branches.new', ['vendors' => $vendors , 'types' => $types]);
    }

    public function store(BranchRequest $request)
    {
        $this->branchService->fillFromRequest($request);
        return redirect(route('admin.branches.index'))->with('success', trans('branch_added_successfully'));
    }

    public function destroy(Branch $branch)
    {
        if (count($branch->orders)) {
            foreach ($branch->orders as $order) {
                if ($order->status == OrderStatus::SUBMITTED || $order->status == OrderStatus::ASSIGNED) {
                    return redirect()->back()->with('danger', trans('cant_delete_this_item_related_with_running_orders'));
                }
            }
        }

        $branch->delete();
        return redirect()->back()->with('success', trans('branch_deleted_successfully'));
    }

    public function edit(Branch $branch)
    {
        $vendors = Vendor::where('active', 1)->get();
        $types = BranchTypes::getList() ;

        return View::make('admin.branches.edit', ['branch' => $branch, 'vendors'=>$vendors, 'types' => $types]);
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        $this->branchService->fillFromRequest($request, $branch);

        return redirect(route('admin.branches.index'))->with('success', trans('branch_updated_successfully'));
    }

    public function export()
    {
        return $this->branchService->export();
    }
}
