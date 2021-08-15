<?php

namespace App\Http\Controllers\Admin;

use App\Constants\BranchTypes;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Unit;
use App\Models\Category;
use App\Repositories\ProductRepository;
use View;

class ProductController extends BaseController
{

    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductService $productService, ProductRepository $productRepository)
    {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->authorizeResource(Product::class, "product");
    }

    public function index()
    {
        $this->authorize("index", Product::class);
        $list = $this->productRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        $count = $this->productRepository->search(request())->count();
        $branchTypes = BranchTypes::getList();

        return View::make("admin.products.index", compact("list", "branchTypes", "count"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::all();
        $categories = Category::all();

        return View::make("admin.products.create", compact("units", "categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProductRequest $request)
    {

        $product = $this->productService->fillFromRequest($request);

        return redirect(route("admin.products.index"))->with('success', trans('item_added_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        $units = Unit::all();
        $categories = Category::all();

        return View::make("admin.products.edit", compact("product", 'units', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param  Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->productService->fillFromRequest($request, $product);

        return redirect(route("admin.products.index"))->with('success', trans('item_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', trans('item_deleted_successfully'));
    }

    /**
     * @param ProductImage $productImage
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteImage(Product $product, ProductImage $productImage)
    {
        $result = $this->productService->deleteImage($product, $productImage);

        if ($result) {
            return back()->with('success', trans('item_deleted_successfully'));
        }

        return back()->with('error', trans('error_not_complete'));
    }

    public function export()
    {
        return $this->productService->export();
    }
}
