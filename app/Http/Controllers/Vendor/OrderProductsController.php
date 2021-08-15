<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Order ;
use App\Models\BranchProduct ;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Services\OrderService;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Requests\Admin\OrderProductsRequest;
use View ;

class OrderProductsController extends BaseController
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Order $order)
    {
        $this->authorize("index", [OrderProduct::class, $order]);
        $list = $order->products;

        return View::make('vendor.orders.products.index', ['list' => $list, 'order'=>$order]);
    }

    public function create(Order $order)
    {
        $this->authorize("create", [OrderProduct::class, $order]);
        $branchProducts = BranchProduct::where('branch_id', $order->branch_id)->get();

        return View::make('vendor.orders.products.new', ['order' => $order, 'branchProducts'=>$branchProducts]);
    }

    public function store(OrderProductsRequest $request, Order $order)
    {
        $this->orderService->fillOrderProductsFromRequest($request);

        return redirect(route('vendor.order.products.index', ['order' => $order->id]))->with('success', trans('order_product_added_successfully'));
    }

    public function edit(Order $order, OrderProduct $orderProduct)
    {
        $this->authorize("update", [OrderProduct::class, $orderProduct, $order]);
        $order = Order::find($orderProduct->order_id);
        $branchProducts = BranchProduct::where('branch_id', $order->branch_id)->get();

        return View::make('vendor.orders.products.edit', ['orderProduct' => $orderProduct, 'branchProducts'=>$branchProducts]);
    }

    public function update(OrderProductsRequest $request, Order $order, OrderProduct $orderProduct)
    {
        $this->orderService->fillOrderProductsFromRequest($request, $orderProduct);
        return redirect(route('vendor.order.products.index', ['order' => $orderProduct->order_id]))->with('success', trans('order_product_updated_successfully'));
    }

    public function destroy(Order $order, OrderProduct $orderProduct)
    {
        $this->authorize("delete", [OrderProduct::class, $orderProduct, $order]);
        $orderProduct->delete();

        return redirect()->back()->with('success', trans('order_product_deleted_successfully'));
    }


}
