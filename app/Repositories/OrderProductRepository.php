<?php

namespace App\Repositories;

use App\Http\Services\ExportService;
use App\Models\OrderProduct;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\Consumption;

class OrderProductRepository
{

    public function consumption(Request $request)
    {
        $orderProduct = OrderProduct::query()
            ->whereHas('product', function ($query) use ($request) {
                $query->select('id')
                    ->when($request->get('name'), function ($orderProduct) use ($request) {
                        return $orderProduct->whereHas('translations', function ($orderProduct) use ($request) {
                            $orderProduct->where('name', 'like', '%' . $request->query->get('name') . '%');
                        });
                    });
            })
            ->whereHas('category', function ($query) use ($request) {
                $query->select('id')
                    ->when($request->get('category_id'), function ($orderProduct) use ($request) {
                        return $orderProduct->where('category_id', '=', $request->get('category_id'));
                    });
            })
            ->with([
                'category', 'product'
            ])
            ->select(\DB::raw('sum(quantity) as quantity , product_id, category_id'))
            ->groupBy('product_id', 'category_id')
            ->orderBy('quantity', 'DESC');

        return $orderProduct;
    }

    public function export()
    {
        $headings = [
            '#',
            'Product Name',
            'Category Name',
            'quantity',
        ];

        $list = $this->consumption(request())->get();
        $listObjects = Consumption::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'consumption Report.xlsx');
    }
}
