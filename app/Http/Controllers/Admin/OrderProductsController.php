<?php

namespace App\Http\Controllers\Admin;

use App\Constants\BranchTypes;
use App\Constants\OrderTypes;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\OrderProductsRequest;
use App\Http\Services\OrderService;
use App\Models\ActualShipment;
use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Repositories\ActualShipmentRepository;
use App\Repositories\OrderProductRepository;
use Illuminate\Routing\Controller;
use View;

class OrderProductsController extends BaseController
{
    protected $orderService;
    protected $orderProductRepository;
    protected $actualShipmentRepository;

    public function __construct(OrderService $orderService, OrderProductRepository $orderProductRepository, ActualShipmentRepository $actualShipmentRepository)
    {
        $this->orderService = $orderService;
        $this->orderProductRepository = $orderProductRepository;
        $this->actualShipmentRepository = $actualShipmentRepository;
    }

    public function index(Order $order)
    {
        if (!$this->orderService->userHasAccess($order)) {
            abort(401);
        }
        $list = $order->products;
        return View::make('admin.orders.products.index', ['list' => $list,'order'=>$order]);
    }

    public function create(Order $order)
    {
        if (!$this->orderService->userHasAccess($order)) {
            abort(401);
        }
        $timeSlots = [];

        $branches = Branch::where('active', true)->where('type', BranchTypes::RETAILER);
        if ($order->type == OrderTypes::SHIPMENT) {
            $branches = Branch::where('active', true)->where('type', '<>', BranchTypes::RETAILER);
        }
        $zone = $order->address?$order->address->location ? $order->address->location->id : '' : '';
        $branches = $branches->whereHas('zones', function ($q) use ($zone) {
            $q->where('zone_id', $zone);
        });
        if ($order->branch_id) {
            $branches = $branches->where('id', $order->branch_id);
        }
        $branches = $branches->get();

        if ($order->type == OrderTypes::SHIPMENT) {
            $timeSlots = [];
            if ($order->shipment_id) {
                $timeSlots = ActualShipment::where('id', $order->shipment_id)->get();
            }
        }

        return View::make('admin.orders.products.new', ['branches' => $branches, 'order' => $order, 'timeSlots' => $timeSlots]);
    }

    public function store(OrderProductsRequest $request, Order $order)
    {
        $this->orderService->fillOrderProductsFromRequest($request);

        return redirect(route('admin.order.products.index', ['order' => $order->id]))->with('success', trans('order_product_added_successfully'));
    }

    public function edit(Order $order, OrderProduct $orderProduct)
    {

        if (!$this->orderService->userHasAccess($order)) {
            abort(401);
        }
        $timeSlots = [];

        $branches = Branch::where('type', BranchTypes::RETAILER);
        if ($order->type == OrderTypes::SHIPMENT) {
            $branches = Branch::where('type', '<>', BranchTypes::RETAILER);
        }
        $zone = $order->address?$order->address->location ? $order->address->location->id : '' : '';
        $branches = $branches->whereHas('zones', function ($q) use ($zone) {
            $q->where('zone_id', $zone);
        });
        if ($order->branch_id) {
            $branches = $branches->where('id', $order->branch_id);
        }
        $branches = $branches->get();

        if ($order->type == OrderTypes::SHIPMENT) {
            $timeSlots = $this->actualShipmentRepository->getTimeSlots($order->address?$order->address->location_id:null, $order->branch_id)->take(5)->get();
            if ($order->shipment_id) {
                $timeSlots = ActualShipment::where('id', $order->shipment_id)->get();
            }
        }

        $branchProducts = BranchProduct::where('branch_id', $order->branch_id)->get();

        return View::make('admin.orders.products.edit', ['branches' => $branches, 'order' => $order, 'orderProduct' => $orderProduct, 'timeSlots' => $timeSlots, 'branchProducts' => $branchProducts]);
    }

    public function update(OrderProductsRequest $request, Order $order, OrderProduct $orderProduct)
    {
        $this->orderService->fillOrderProductsFromRequest($request, $orderProduct);

        return redirect(route('admin.order.products.index', ['order' => $orderProduct->order_id]))->with('success', trans('order_product_updated_successfully'));
    }

    public function destroy(Order $order, OrderProduct $orderProduct)
    {
        if (!$this->orderService->userHasAccess($order)) {
            abort(401);
        }

        $this->orderService->inStock($orderProduct);

        $orderProduct->delete();

        $order->total_price = $this->orderService->getOrderTotalCost($order->id) + $this->orderService->getOrderDeliveryFee($order);
        $order->save();

        if ($order->shipment_id) {
            $shipment = ActualShipment::find($order->shipment_id);
            $this->orderService->setShipmentCapacity($shipment);
            $parentShipment = ActualShipment::find($shipment->parent_id);
            $this->orderService->setParentShipmentCapacity($parentShipment);
        }

        return redirect()->back()->with('success', trans('order_product_deleted_successfully'));
    }

    public function consumption()
    {
        $categories = Category::all();
        $list = $this->orderProductRepository->consumption(request())->paginate(10);
        $list->appends(request()->all());

        return View::make('admin.consumption.index', ['list' => $list, 'categories'=>$categories]);
    }

    public function export()
    {
        return $this->orderProductRepository->export();
    }
}
