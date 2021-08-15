<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Vendor\BranchProductsRequest;
use App\Http\Services\BranchProductsService;
use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\Category;
use App\Models\Product;
use View;

class BranchProductsController extends BaseController
{
    /**
     * @var BranchProductsService
     */
    private $branchProductsService;

    /**
     * BranchProductsController constructor.
     * @param BranchProductsService $branchProductsService
     */
    public function __construct(BranchProductsService $branchProductsService)
    {
        $this->branchProductsService = $branchProductsService;
    }

    public function index(Branch $branch)
    {
        $this->authorize("index", [BranchProduct::class, $branch]);

        $list = $branch->products;
        return View::make('vendor.branches.products.index', ['list' => $list, 'branch' => $branch]);
    }

    public function create(Branch $branch)
    {
        $this->authorize("create", [BranchProduct::class, $branch]);

        $categories = Category::where('active', '=', true)->get();
        return View::make('vendor.branches.products.create', ['branch' => $branch, 'categories' => $categories]);
    }

    public function store(BranchProductsRequest $request, Branch $branch)
    {
        $this->branchProductsService->fillFromRequest($request);
        return redirect(route('vendor.branch.products.index', ['branch' => $branch->id]))
            ->with('success', trans('branch_product_added_successfully'));
    }

    public function edit(Branch $branch, BranchProduct $branchProduct)
    {
        $this->authorize("update", [BranchProduct::class, $branchProduct, $branch]);

        $categories = Category::where('active', '=', true)->get();
        $products = Product::query()->where('category_id', $branchProduct->category_id)->get();
        return View::make(
            'vendor.branches.products.edit',
            [
                'branchProduct' => $branchProduct,
                'categories' => $categories,
                'products' => $products,
                'branch' => $branch
            ]
        );
    }

    public function update(BranchProductsRequest $request, Branch $branch, BranchProduct $branchProduct)
    {
        $this->branchProductsService->fillFromRequest($request, $branchProduct);
        return redirect(route('vendor.branch.products.index', ['branch' => $branchProduct->branch_id]))
            ->with('success', trans('branch_product_updated_successfully'));
    }

    public function destroy(Branch $branch, BranchProduct $branchProduct)
    {
        $this->authorize("delete", [BranchProduct::class, $branchProduct, $branch]);
        $branchProduct->delete();
        return redirect()->back()->with('success', trans('branch_product_deleted_successfully'));
    }
}
