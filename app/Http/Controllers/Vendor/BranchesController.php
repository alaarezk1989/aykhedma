<?php

namespace App\Http\Controllers\Vendor;

use App\Constants\BranchTypes;
use App\Http\Requests\Vendor\BranchProductsRequest;
use App\Http\Requests\Vendor\BranchRequest;
use App\Http\Services\BranchService;
use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use View;

class BranchesController extends BaseController
{
    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * BranchesController constructor.
     * @param BranchService $branchService
     */
    public function __construct(BranchService $branchService)
    {
        $this->authorizeResource(Branch::class, "branch");
        $this->branchService = $branchService;
    }

    public function index()
    {
        $this->authorize("index", Branch::class);

        $list = Branch::query()
            ->where("vendor_id", "=", auth()->user()->vendor_id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return View::make('vendor.branches.index', ['list' => $list]);
    }

    public function create()
    {
        $vendors = [];
        $types = BranchTypes::getList() ;

        return View::make('vendor.branches.create', compact('vendors', 'types'));
    }

    public function store(BranchRequest $request)
    {
        $this->branchService->fillFromRequest($request);
        return redirect(route('vendor.branches.index'))->with('success', trans('branch_added_successfully'));
    }

    public function edit(Branch $branch)
    {
        $vendors = [] ;
        $types = BranchTypes::getList() ;

        return View::make("vendor.branches.edit", compact("branch", "vendors", "types"));
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        $this->branchService->fillFromRequest($request, $branch);

        return redirect(route('vendor.branches.index'))->with('success', trans('branch_updated_successfully'));
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return back()->with('success', trans('branch_deleted_successfully'));
    }
}
