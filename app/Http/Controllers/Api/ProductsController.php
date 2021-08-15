<?php

namespace App\Http\Controllers\Api;

use App\Models\BranchProduct;
use App\Repositories\ProductRepository;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $list = $this->productRepository->searchFromRequest($request)->get();

        return response()->json($list);
    }

    public function info(BranchProduct $branchProduct)
    {
        $branchProduct = BranchProduct::with('product', 'product.images')->find($branchProduct->id);

        $similar = BranchProduct::with('product', 'product.images')->where('category_id', $branchProduct->category_id)
            ->where('branch_id', $branchProduct->branch_id)->limit(3)->get();

        return response()->json(['product' => $branchProduct, 'similar' => $similar]);
    }
}
