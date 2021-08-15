<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderProduct;

class ReportRepository
{
    public function quantityAnalysis($request)
    {
        if (!$request->filled('vehicle_id') && !$request->filled('from_date') && !$request->filled('to_date')) {
            return OrderProduct::where('id',0);
        }

        $list = OrderProduct::whereHas('order', function($q) use ($request) {
                $q->where('shipment_id', '<>', null);
            })
            ->select('order_products.*', \DB::raw('SUM(quantity) as boxes, SUM(quantity)* products.per_kilogram  as kilos'))
            ->with(['product', 'order'])
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->groupBy('branch_product_id');

        if ($request->filled('vehicle_id')) {
            $list->whereHas('order.shipment', function($q) use ($request) {
              $q->where('vehicle_id', $request->get('vehicle_id'));
            });
        }
        if ($request->filled('from_date')) {
            $list->whereHas('order', function($q) use ($request) {
                $q->where('created_at', '>=', $request->get('from_date'));
            });
        }
        if ($request->filled('to_date')) {
            $list->whereHas('order', function($q) use ($request) {
                $q->where('created_at', '<=', $request->get('to_date'));
            });
        }

        return $list;
    }
}