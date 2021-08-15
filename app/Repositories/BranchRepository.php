<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\Permissible;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class BranchRepository
{

    /**
     * @param $request
     * @return $this|mixed
     */
    public function search(Request $request)
    {
        $branches = Branch::query()->orderByDesc("id");

        if ($request->get('filter_by') == "vendor_id" && !empty($request->get('q'))) {
            $branches->where($request->get('filter_by'), $request->get('q'));
        }
        if ($request->get('filter_by') == "name" && !empty($request->get('q'))) {
            $branches->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('q') . '%');
            });
        }
        if ($request->get('filter_by') == "zone_id" && !empty($request->get('q'))) {
            $branches->whereHas('zones', function ($query) use ($request) {
                $query->where('zone_id', $request->query->get('q'));
            });
        }
        if ($request->has('type') && !empty($request->get('type'))) {
            $branches->where('type', $request->get('type'));
        }
        if ($request->filled('vendor')) {
            $branches->where('vendor_id', $request->get('vendor'));
        }

        if (Auth::check() && Permissible::where('user_id', auth()->user()->id)->where('permissible_type', 'App\Models\Branch')->first()) {
            $branches->whereHas('permissible', function ($q) {
                $q->where('user_id', auth()->user()->id);
            });
        }

        return $branches;
    }

    public function searchProductsFromRequest($request)
    {
        $products = BranchProduct::with('product', 'product.images')
            ->select('branch_products.*',
                'units_translations.name as unit_name',
                \DB::raw('SUM(ifnull(in_amount,0)) -  SUM(ifnull(out_amount,0)) as stock_balance'))
            ->leftJoin('products', 'branch_products.product_id', '=', 'products.id')
            ->leftJoin('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->leftJoin('units', 'products.unit_id', '=', 'units.id')
            ->leftJoin('units_translations', 'units.id', '=', 'units_translations.unit_id')
            ->leftJoin('stocks', 'branch_products.id', '=', 'stocks.product_id')
            ->where('branch_products.active', true)
            ->groupBy('branch_products.id')
            ->orderBy('product_translations.name', 'asc');

        if ($request->has('category')) {
            $products->where('products.category_id', '=', $request->get('category'));
        }

        if ($request->has('branch')) {
            $products->where('branch_id', '=', $request->get('branch'));
        }

        if ($request->has('keyword')) {
            $products->whereHas('product.translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('keyword') . '%');
            });
        }

        $products->where('product_translations.locale', app()->getLocale());
        $products->where('units_translations.locale', app()->getLocale());

        return $products;
    }

    public function branchesByVendor(Request $request)
    {
        $branches = Branch::where('branches.active', 1)->orderByDesc("id");

        if ($request->filled('vendor_id')) {
            $branches->where('vendor_id', $request->get('vendor_id'));
        }
        if ($request->filled('zone_id')) {
            $branches->whereHas('zones', function ($query) use ($request) {
                $query->where('zone_id', $request->get('zone_id'));
            });
        }

        return $branches;
    }
}
