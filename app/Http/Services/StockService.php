<?php

namespace App\Http\Services;

use App\Http\Resources\Stocks;
use App\Models\Product;
use App\Models\Stock;
use App\Repositories\StockRepository;
use Symfony\Component\HttpFoundation\Request;
use Maatwebsite\Excel\Facades\Excel;

class StockService
{

    protected $stockRepository;
    protected $stock;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function fillFromRequest(Request $request)
    {
        $stock = new Stock();

        $balance = $this->stockRepository->getBalance($request->input("product_id"));

        $stock->fill($request->request->all());

        $stock->balance = $balance + $request->input("in_amount") - $request->input("out_amount") ;

        $stock->created_by = auth()->id();

        $stock->save();

        return $stock;
    }

    public function export()
    {
        $headings = [
            [trans('stocks_list')],
            [
                '#',
                trans('product'),
                trans('in_amount'),
                trans('out_amount'),
                trans('balance'),
                trans('branch'),
                trans('vendor'),
                trans('created_by'),
                trans('created_at')
            ]
        ];
        $list = $this->stockRepository->search(request())->get();
        $listObjects = Stocks::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Stocks Report.xlsx');
    }
}
