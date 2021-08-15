<?php

namespace App\Http\Controllers\Vendor;

use App\Constants\OrderStatus;
use App\Constants\PaymentTypes;
use App\Models\Order ;
use App\Models\User ;
use App\Models\Branch ;
use App\Models\Address ;
use App\Models\BranchProduct ;
use App\Models\OrderProduct;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Services\OrderService;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Requests\Admin\OrderProductsRequest;
use App\Constants\UserTypes;
use View ;

class OrderController extends BaseController
{
    protected $orderService;
    protected $orderRepository;
    public function __construct(OrderService $orderService, OrderRepository $orderRepository)
    {
        $this->authorizeResource(Order::class, 'order');
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $this->authorize("index", Order::class);
        $status = OrderStatus::getList();
        $paymentTypes = PaymentTypes::getList();

        request()->request->add(['vendor_id' => auth()->user()->vendor_id]);

        $list = $this->orderRepository->search(request())->paginate(10);
        $list->appends(request()->all());

        return View('vendor.orders.index', compact('list', 'status', 'paymentTypes'));
    }

    public function edit(Order $order)
    {
        $users = User::where('type', UserTypes::NORMAL)->get();

        $drivers = User::where('type', UserTypes::DRIVER)
            ->where('vendor_id', Auth()->user()->vendor_id)
            ->get();

        $addresses = Address::where('user_id', $order->user_id)->get();

        $branches = Branch::where('vendor_id', Auth()->user()->vendor_id)->get();

        return View::make('vendor.orders.edit', ['order' => $order,'users'=>$users, 'addresses'=>$addresses,'branches'=>$branches, 'drivers' => $drivers]);
    }

    public function show(Order $order)
    {
        $list = $order->Products;
        return View::make('vendor.orders.products.index', ['list' => $list,'order'=>$order]);
    }

    public function create()
    {
        $users = User::where('type', UserTypes::NORMAL)->get();

        $branchList = Branch::where('vendor_id', auth()->user()->vendor_id)->get();

        return View::make('vendor.orders.new', ['users'=>$users, 'branchList'=>$branchList]);
    }

    public function store(OrderRequest $request)
    {
        $this->orderService->fillFromRequest($request);
        return redirect(route('vendor.orders.index'))->with('success', trans('order_added_successfully'));
    }


    public function update(OrderRequest $request, Order $order)
    {
        $this->orderService->fillFromRequest($request, $order);

        return redirect(route('vendor.orders.index'))->with('success', trans('order_updated_successfully'));
    }

    public function addProduct(Order $order)
    {
        $branchProducts = BranchProduct::where('branch_id', $order->branch_id)->get();

        return View::make('vendor.orders.products.new', ['order' => $order,'branchProducts'=>$branchProducts]);
    }

    public function storeProduct(OrderProductsRequest $request, Order $order)
    {
        $this->orderService->fillOrderProductsFromRequest($request);
        return redirect(route('vendor.order.products', ['order' => $order->id]))->with('success', trans('order_product_added_successfully'));
    }

    public function editProduct(OrderProduct $orderProduct)
    {
        $order = Order::find($orderProduct->order_id);

        $branchProducts = BranchProduct::where('branch_id', $order->branch_id)->get();

        return View::make('vendor.orders.products.edit', ['orderProduct' => $orderProduct,'branchProducts'=>$branchProducts]);
    }

    public function updateProduct(OrderProductsRequest $request, OrderProduct $orderProduct)
    {
        $this->orderService->fillOrderProductsFromRequest($request, $orderProduct);
        return redirect(route('vendor.order.products', ['order' => $orderProduct->order_id]))->with('success', trans('order_product_updated_successfully'));
    }

    public function destroyProduct(OrderProduct $orderProduct)
    {
        $orderProduct->delete();
        return redirect()->back()->with('success', trans('order_product_deleted_successfully'));
    }

    public function products(Order $order)
    {
        $list = $order->products;
        return View::make('vendor.orders.products.index', ['list' => $list,'order'=>$order]);
    }

    public function confirm(Order $order)
    {
        $this->orderService->orderConfirm($order);
        return redirect(route('vendor.orders.index'))->with('success', trans('order_confirmed_successfully'));
    }
}
