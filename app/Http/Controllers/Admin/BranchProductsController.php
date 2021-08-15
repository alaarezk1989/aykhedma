<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BranchProductsCopyRequest;
use App\Http\Requests\Admin\BranchProductsRequest;
use Illuminate\Http\Request;
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
        $branches = Branch::query()->where('active', true)
            ->where('type', $branch->type)
            ->where('id', '!=', $branch->id)
            ->get();

        return View::make('admin.branches.products.index', ['list' => $list,'branch'=>$branch, 'branches' => $branches]);
    }

    public function create(Branch $branch)
    {
        $this->authorize("create", [BranchProduct::class, $branch]);
        $categories = Category::where('active', 1)->get();
        $products = [];
        if (old('category_id')) {
            $products = Product::where('category_id', old('category_id'))->get();
        }


        return View::make('admin.branches.products.new', ['branch' => $branch,'categories'=>$categories, 'products' => $products]);
    }

    public function store(BranchProductsRequest $request, Branch $branch)
    {
        $this->branchProductsService->fillFromRequest($request);
        return redirect(route('admin.branch.products.index', ['branch' => $branch->id]))
            ->with('success', trans('branch_product_added_successfully'));
    }

    public function edit(Branch $branch, BranchProduct $branchProduct)
    {
        $this->authorize("update", [BranchProduct::class, $branchProduct, $branch]);
        $categories = Category::where('active', 1)->get();
        $products = Product::where('category_id', $branchProduct->category_id)->get();
        return View::make(
            'admin.branches.products.edit',
            [
                'branchProduct' => $branchProduct,
                'categories'=>$categories,
                'products'=>$products,
                'branch' => $branch
            ]
        );
    }

    public function update(BranchProductsRequest $request, Branch $branch, BranchProduct $branchProduct)
    {
        $this->branchProductsService->fillFromRequest($request, $branchProduct);
        return redirect(route('admin.branch.products.index', ['branch' => $branchProduct->branch_id]))
            ->with('success', trans('branch_product_updated_successfully'));
    }

    public function destroy(Branch $branch, BranchProduct $branchProduct)
    {
        $this->authorize("delete", [BranchProduct::class, $branchProduct, $branch]);
        $branchProduct->delete();
        return redirect()->back()->with('success', trans('branch_product_deleted_successfully'));
    }

    public function copy(BranchProductsCopyRequest $request, Branch $newBranch)
    {
        $oldBranchProducts = Branch::find($request->get('old_branch'))->products;
        $newBranch->products()->detach();
        $data = [];
        foreach ($oldBranchProducts as $oldBranchProduct) {
             $data [] = [
                    "branch_id" => $newBranch->id,
                    "product_id" => $oldBranchProduct->pivot["product_id"],
                    "category_id" => $oldBranchProduct["category_id"],
                    "price" => $oldBranchProduct->pivot["price"],
                    "discount" => $oldBranchProduct->pivot["discount"],
                    "discount_till" => $oldBranchProduct->pivot["discount_till"],
                    "wholesale" => $oldBranchProduct->pivot["wholesale"],
                    "active" => $oldBranchProduct->pivot["active"],
             ];
        }

        BranchProduct::insert($data);

        return redirect()->back()->with('success', trans('branch_product_copied_successfully'));
    }
}
