<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StockRequest;
use App\Http\Services\StockService;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\BranchProduct;
use App\Repositories\StockRepository;
use View;

class StocksController extends BaseController
{
    protected $stockService;
    protected $stockRepository;
    public function __construct(StockService $stockService, StockRepository $stockRepository)
    {
        $this->authorizeResource(Stock::class, "stock");
        $this->stockService = $stockService;
        $this->stockRepository = $stockRepository;
    }

    public function index()
    {
        $this->authorize("index", Stock::class);
        $list = $this->stockRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        return View::make('admin.stocks.index', ['list' => $list]);
    }

    public function create()
    {
        $branches = Branch::where('active',1)->get();
        $products = [];
        if (old('branch_id')) {
            $products = BranchProduct::where('branch_id',old("branch_id"))->whereHas('product')->with('product')->get();
        }

        return View::make('admin.stocks.new', ['branches' => $branches, 'products' => $products]);
    }

    public function store(StockRequest $request)
    {
        $this->stockService->fillFromRequest($request);
        return redirect(route('admin.stocks.index'))->with('success', trans('stock_added_successfully'));
    }

    public function export()
    {
        return $this->stockService->export();
    }
}
