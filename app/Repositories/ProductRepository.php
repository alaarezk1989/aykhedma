<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\BranchProduct;
use Symfony\Component\HttpFoundation\Request;

class ProductRepository
{
    /**
     * @param $request
     * @return mixed
     */
    public function searchFromRequest($request)
    {
        $products = Product::orderBy('id', 'DESC');

        if ($request->query->has('category')) {
            $products->where('category_id', '=', $request->query->get('category'));
        }

        return $products;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getBranchProductPrice($request)
    {
        $branchProduct = BranchProduct::where('id', '=', $request->query->get('branchProductId'));
        return $branchProduct;
    }

    /**
     * @param $productId
     * @return mixed
     */
    public function getProductPrice($productId)
    {
        $product = Product::where('id', '=', $productId);
        return $product;
    }

    /**
     * @param $request
     * @return $this|mixed
     */
    public function search(Request $request)
    {
        $products = Product::query()->orderByDesc("id")
            ->when($request->get('bundle'), function ($products) use ($request) {
                return $products->where('bundle', '=', $request->get('bundle'));
            });

        if ($request->get('filter_by') == "category_id" && !empty($request->get('q'))) {
            $products->where("category_id", '=', $request->get("q"));
        }
        if ($request->get('filter_by') == "name" && !empty($request->get('q'))) {
            $products->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('q') . '%');
            });
        }
        if ($request->get('filter_by') == "branch_id" && !empty($request->get('q'))) {
            $products->whereHas('branches', function ($query) use ($request) {
                $query->where('branch_id', $request->query->get('q'));
            });
        }
        if ($request->get('branch_type') && !empty($request->get('branch_type'))) {
            $products->whereHas('branches', function ($query) use ($request) {
                $query->where('branches.type', $request->query->get('branch_type'));
            });
        }
        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $products->where('created_at', '>=', $request->get('from_date'));
        }
        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $products->where('created_at', '<=', $request->get('to_date'));
        }

        return $products;
    }
}
