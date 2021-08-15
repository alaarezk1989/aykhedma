<?php

namespace App\Repositories;

use App\Models\Stock;
use Symfony\Component\HttpFoundation\Request;

class StockRepository
{
    public function getBalance($product)
    {
        $inAmount = Stock::where('product_id', $product)->groupBy('product_id')->sum('in_amount');

        $outAmount = Stock::where('product_id', $product)->groupBy('product_id')->sum('out_amount');

        return $inAmount - $outAmount;
    }

    public function search(Request $request)
    {
        $stocks = Stock::query()->orderByDesc("id");

        if ($request->get('filter_by') == "branch_id" && !empty($request->get('q'))) {
            $stocks->whereHas('product.branch', function ($query) use ($request) {
                $query->where('id', $request->query->get('q'));
            });
        }

        if ($request->get('filter_by') == "vendor_id" && !empty($request->get('q'))) {
            $stocks->whereHas('product.branch.vendor', function ($query) use ($request) {
                $query->where('id', $request->query->get('q'));
            });
        }

        if ($request->get('filter_by') == "product_id" && !empty($request->get('q'))) {
            $stocks->where('product_id', $request->get('q'));
        }

        if ($request->get('filter_by') == "product_name" && !empty($request->get('q'))) {
            $stocks->whereHas('product.product.translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('q') . '%');
            });
        }

        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $stocks->where('created_at', '>=', $request->get('from_date'));
        }

        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $stocks->where('created_at', '<=', $request->get('to_date'));
        }

        return $stocks;
    }
}
