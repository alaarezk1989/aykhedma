<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OrderStatus;
use App\Constants\OrderTypes;
use App\Constants\UserTypes;
use App\Constants\VendorTypes;
use App\Constants\PaymentTypes;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Services\OrderService;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Repositories\OrderRepository;
use View;

class OrdersController extends BaseController
{
    protected $orderService;
    protected $orderRepository;

    public function __construct(OrderService $orderService, OrderRepository $orderRepository)
    {
        $this->authorizeResource(Order::class, 'order');
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize("index", Order::class);
        $status = OrderStatus::getList();
        $types = VendorTypes::getList();
        $paymentTypes = PaymentTypes::getList();
        $ordersCount = $this->orderRepository->search(request())->count();
        $companies = Company::all();

        $list = $this->orderRepository->search(request())->paginate(10);
        $list->appends(request()->all());

        $branches = Branch::where('active', 1)->get();
        $vendors = \App\Models\Vendor::where('active', 1)->get();
        $drivers = User::where('active', 1)->whereIn('type',[UserTypes::DRIVER, UserTypes::PUBLIC_DRIVER,UserTypes::DELIVERY_PERSONAL])->get();

        return View::make('admin.orders.index', ['list' => $list, 'status' => $status, 'ordersCount' => $ordersCount, 'types' => $types, 'paymentTypes' => $paymentTypes, 'companies' => $companies, 'branches' => $branches, 'vendors' => $vendors, 'drivers' => $drivers]);
    }

    public function create()
    {
        $users = User::where('type', UserTypes::NORMAL)->where('active', 1)->orderBy('id', 'DESC')->get();

        return View::make('admin.orders.new', ['users'=>$users]);
    }

    public function store(OrderRequest $request)
    {
        $this->orderService->fillFromRequest($request);

        return redirect(route('admin.orders.index'))->with('success', trans('order_added_successfully'));
    }

    public function edit(Order $order)
    {
        if (!$this->orderService->userHasAccess($order)) {
            abort(401);
        }
        $users = User::where('type', UserTypes::NORMAL)->where('active', 1)->orderBy('id', 'DESC')->get();

        $addresses = Address::where('user_id', $order->user_id)->get();

        $drivers = User::where('type', UserTypes::DRIVER)
            ->where('branch_id', $order->branch_id)
            ->where('active', 1)
            ->get();

        return View::make('admin.orders.edit', ['order' => $order,'users'=>$users, 'addresses'=>$addresses, 'drivers' => $drivers]);
    }

    public function update(OrderRequest $request, Order $order)
    {
        $this->orderService->fillFromRequest($request, $order);

        return redirect(route('admin.orders.index'))->with('success', trans('order_updated_successfully'));
    }

    public function show(Order $order)
    {
        if (!$this->orderService->userHasAccess($order)) {
            abort(401);
        }

        $products = $order->products;

        return View::make('admin.orders.show', ['order' => $order, 'products' => $products]);
    }

    public function destroy(Order $order)
    {
        if (!$this->orderService->userHasAccess($order)) {
            abort(401);
        }

        if ($order->status != OrderStatus::SUBMITTED && $order->status != OrderStatus::CANCELLED) {
            return redirect()->back()->with('danger', trans('cant_delete_this_order'));
        }

        $order->products()->detach();
        $this->orderService->inStock($order->products);
        $order->delete();


        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function export()
    {
        return $this->orderService->export();
    }
}
