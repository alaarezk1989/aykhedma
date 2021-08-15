<?php

namespace App\Http\Services;

use App\Constants\BranchTypes;
use App\Constants\OrderStatus;
use App\Constants\OrderTypes;
use App\Constants\PaymentStatus;
use App\Constants\PaymentTypes;
use App\Constants\TransactionTypes;
use App\Mail\CancelOrderClientMail;
use App\Mail\CreateOrderClientMail;
use App\Models\ActualShipment;
use App\Models\Address;
use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\BranchZone;
use App\Models\Coupon;
use App\Models\Location;
use App\Models\Permissible;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Segmentation;
use App\Models\Setting;
use App\Models\Vehicle;
use App\Models\Voucher;
use App\Repositories\BranchRepository;
use App\Repositories\OrderRepository;
use App\Repositories\SegmentationRepository;
use App\Repositories\UserRepository;
use App\Http\Services\ExportService;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\Orders;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Request;
use App\Models\DriverOrders ;
use App\Constants\DriverOrderStatus ;
use App\Constants\UserTypes ;
use App\Constants\CancellationList ;
use Carbon\Carbon;
use App\Jobs\OrderNotification;

class OrderService
{
    protected $orderRepository;
    protected $userRepository;
    protected $branchRepository;
    protected $segmentationRepository;
    protected $stockService;
    protected $transactionService;
    protected $revenueService;
    protected $paymentService;
    protected $userService;
    protected $notificationService;

    public function __construct(OrderRepository $orderRepository, StockService $stockService, PaymentService $paymentService, UserRepository $userRepository, UserService $userService, BranchRepository $branchRepository, SegmentationRepository $segmentationRepository, TransactionService $transactionService, RevenueService $revenueService, NotificationService $notificationService)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->branchRepository = $branchRepository;
        $this->stockService = $stockService;
        $this->transactionService = $transactionService;
        $this->revenueService = $revenueService;
        $this->paymentService = $paymentService;
        $this->userService = $userService;
        $this->segmentationRepository = $segmentationRepository;
        $this->notificationService = $notificationService;
    }

    public function fillFromRequest(Request $request, $order = null)
    {
        if (!$order) {
            $order = new order();
        }
        $order->fill($request->request->all());

        if ($request->has('shipment_id')) {
            $order->shipment_id = $request->get('shipment_id');
        }

        $order->status = OrderStatus::SUBMITTED;

        if ($request->filled('status')) {
            if ($request->get('status') == OrderStatus::SUBMITTED) {
                $order->driver_id = null;
            }

            if ($request->get('status') == OrderStatus::DELIVERED) {
                $this->confirm($order);
            }

            if ($request->get('status') == OrderStatus::CANCELLED) {
                $this->cancelOrder($order);
            }

            if ($request->get('status') == OrderStatus::ASSIGNED) {
                $request->request->add(['order_id' => $order->id]);
                $this->assignDriver($request);
            }
        }

        $order->save();

        return $order;
    }

    public function fillOrderProductsFromRequest(Request $request, $orderProduct = null)
    {
        if (!$orderProduct) {
            $orderProduct = new OrderProduct();
        }

        $branchProduct = BranchProduct::find($request->request->get('branch_product_id'));
        $orderProduct->fill($request->request->all());

        $branchProductPrice = $branchProduct->price;
        if ($branchProduct->discount != null && $branchProduct->discount != 0 && $branchProduct->discount_till > Carbon::now()) {
            $branchProductPrice = $branchProduct->price - ($branchProduct->price * ($branchProduct->discount/100));
        }

        $orderProduct->price = ($branchProductPrice * $request->request->get('quantity'));
        $orderProduct->category_id = $branchProduct->category_id;
        $orderProduct->product_id = $branchProduct->product_id;
        $orderProduct->save();

        $order = Order::find($orderProduct->order_id);
        $branch = Branch::find($branchProduct->branch_id);
        $order->branch_id = $branch->id;

        $shipment = 0;
        if (($branch->type == BranchTypes::SUPPLIER || $branch->type == BranchTypes::HUB) && $request->filled('shipment_id')) {
            $shipment = ActualShipment::find($request->get('shipment_id'));

            $order->shipment_id = $request->get('shipment_id');
            $order->driver_id = Vehicle::find($shipment->vehicle_id)->driver_id;
            $order->status = OrderStatus::ASSIGNED;

            $orderDriver = new DriverOrders();
            $orderDriver->order_id = $order->id;
            $orderDriver->driver_id = Vehicle::find($shipment->vehicle_id)->driver_id;
            $orderDriver->status = DriverOrderStatus::DRIVER_ACCEPT;

            $orderDriver->save();

            $order->expected_delivery_time = $shipment->to_time;
        }
        if (!$request->filled('shipment_id')) {
            $order->expected_delivery_time = $this->calculateExpectedDeliveryTime($order);
        }

        $order->total_price = $this->getOrderTotalCost($order->id) + $this->getOrderDeliveryFee($order);

        $order->save();

        if ($shipment) {
            $this->setShipmentCapacity($shipment);
            $parentShipment = ActualShipment::find($shipment->parent_id);
            $this->setParentShipmentCapacity($parentShipment);
        }

        if ($request->filled('old_product')) {
            if ($request->get("old_product") != $request->get("branch_product_id")) {
                //the product was changed, so update stock of old one then the new one
                $orderProduct->quantity = $request->get('old_quantity');
                $orderProduct->branch_product_id = $request->get('old_product');
                $this->inStock($orderProduct);

                $orderProduct->quantity = $request->get('quantity');
                $orderProduct->branch_product_id = $request->get('branch_product_id');
                $this->outStock($orderProduct);
            } else {
                if ($request->filled('old_quantity')) {
                    $quantity = $request->get('quantity') - $request->get('old_quantity');
                    if ($quantity > 0) {
                        $orderProduct->quantity = $quantity;
                        $this->outStock($orderProduct);
                    }
                    if ($quantity < 0) {
                        $orderProduct->quantity = $quantity * -1;
                        $this->inStock($orderProduct);
                    }
                }
            }
        }

        if (!$request->filled('old_quantity') && !$request->filled('old_product')) {
            // add new product, so normally update the product stock
            $this->outStock($orderProduct);
        }

        return $orderProduct;
    }

    public function fillApiRequest(Request $request, $order = null)
    {
        if (!$order) {
            $order = new order();
        }

        $order->fill($request->request->all());

        $order->status = OrderStatus::SUBMITTED;

        $order->save();

        $branchProducts = [];
        $products = $request->request->get('products');
        foreach ($products as $product) {
            $branchProduct = BranchProduct::find($product['id']);
            $branch = Branch::find($branchProduct->branch_id);

            $branchProductPrice = $branchProduct->price;
            if ($branchProduct->discount != null && $branchProduct->discount != 0 && $branchProduct->discount_till > Carbon::now()) {
                $branchProductPrice = $branchProduct->price - ($branchProduct->price * ($branchProduct->discount/100));
            }

            $product['price'] = ($branchProductPrice * $product['quantity']);
            $product['branch_product_id'] = $product['id'];
            $product['category_id'] = $branchProduct->category_id;
            $product['product_id'] = $branchProduct->product_id;

            unset($product['id']);
            $branchProducts[] = $product;
        }
        $order->products()->attach($branchProducts);
        $order->branch_id = $branch->id;
        $order->save();

        $totalPrice = $this->getOrderTotalCost($order->id) + $this->getOrderDeliveryFee($order);
        $order->total_price = $totalPrice;
        $order->expected_delivery_time = $this->calculateExpectedDeliveryTime($order);

        $shipment = 0;
        if (($branch->type == BranchTypes::SUPPLIER || $branch->type == BranchTypes::HUB) && $request->filled('shipment_id')) {
            $shipment = ActualShipment::find($request->get('shipment_id'));

            $order->shipment_id = $request->get('shipment_id');
            $order->driver_id = $shipment->driver_id;
            $order->status = OrderStatus::ASSIGNED;

            $orderDriver = new DriverOrders();
            $orderDriver->order_id = $order->id;
            $orderDriver->driver_id = $shipment->driver_id;
            $orderDriver->status = DriverOrderStatus::DRIVER_ACCEPT;
            $orderDriver->save();

            $order->expected_delivery_time = $shipment->to_time;
            $order->type = OrderTypes::SHIPMENT;
        }

        if ($request->filled('code')) {
            $this->applyPromotionCode($request, $order);
        }
        if ($request->filled('points')) {
            $this->redeemPoints($request->get('points'), $order);
        }

        $order->save();
        if ($shipment) {
            $this->setShipmentCapacity($shipment);
            $parentShipment = ActualShipment::find($shipment->parent_id);
            $this->setParentShipmentCapacity($parentShipment);
        }

        if ($order->payment_type == PaymentTypes::ONLINE_PAYMENT) {
            $this->submitOrderAccountingOnline($order);
        }

        $this->outStock($order->products);

        $type = 'new_order';
        $vendorTitleNotificationMessage = $type;
        $clientNotificationTitleMessage = $type;
        $clientMailable = new CreateOrderClientMail($order, $order->user);

        $this->orderNotification($order, $vendorTitleNotificationMessage, $clientMailable, $clientNotificationTitleMessage);

        return $order;
    }

    public function setOrderTotalCost($orderId)
    {
        $orderProductTotalPrice = $this->getOrderTotalCost($orderId);
        $order = Order::find($orderId);
        $order->total_price = $orderProductTotalPrice + $this->getOrderAykhedmaFee(Order::find($orderId)) + $this->getOrderDeliveryFee(Order::find($orderId));

        $order->save();
    }

    public function getOrderTotalCost($orderId)
    {
        $orderTotalPrice = OrderProduct::where('order_id', $orderId)->sum('price');

        return $orderTotalPrice;
    }

    public function export()
    {
        $headings = [
            [trans('orders_list')],
            ['#',
                trans('shipment'),
                trans('parent_shipment_#'),
                trans('user_name'),
                trans('address'),
                trans('branch'),
                trans('total_price'),
                trans('promo_code'),
                trans('promo_type'),
                trans('points_used'),
                trans('final_amount'),
                trans('created_at'),
                trans('expected_delivery_time'),
                trans('status')
            ]
        ];
        $list = $this->orderRepository->search(request())->get();
        $listObjects = Orders::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Orders Report.xlsx');
    }

    public function cancelOrder($order)
    {
        if ($order->status == OrderStatus::SUBMITTED || auth()->user()->type != UserTypes::NORMAL || ($order->shipment_id && $order->status == OrderStatus::ASSIGNED) ) {
            $order->status = OrderStatus::CANCELLED;
            $order->save();

            if ($order->points_used) {
                $this->gainPoints($order, $order->points_used);
            }

            if ($order->shipment_id != null) {
                $shipment = ActualShipment::find($order->shipment_id);
                $shipment->load  -= $this->calculateOrderLoad($order->products);
                $shipment->save();

                if ($shipment->parent_id != null) {
                    $parentShipment = ActualShipment::find($shipment->parent_id);
                    $parentShipment->load  -= $this->calculateOrderLoad($order->products);
                    $parentShipment->save();
                }
            }

            $type = 'order_cancelled';
            $vendorTitleNotificationMessage = $type;
            $clientNotificationTitleMessage = $type;
            $clientMailable = new CancelOrderClientMail($order, $order->user);
            $this->orderNotification($order, $vendorTitleNotificationMessage, $clientMailable, $clientNotificationTitleMessage);

            if ($order->payment_type == PaymentTypes::ONLINE_PAYMENT) {
                $this->cancelOrderAccountingOnline($order);
            }

            $this->inStock($order->products);

            return $order;
        }
        return false;
    }

    public function assignDriver(Request $request)
    {
        $order = Order::find($request->get('order_id'));

        $order->status = OrderStatus::ASSIGNED;
        $order->driver_id = $request->get('driver_id');
        $order->save();

        $orderDriver = new DriverOrders();

        $orderDriver->order_id = $request->get('order_id');
        $orderDriver->driver_id = $request->get('driver_id');
        $orderDriver->save();

        $messageData["title"] = 'new_order_assigned';
        $messageData["body"] = $order;
        $this->notificationService->sendPush($order->driver, $messageData);

        return $orderDriver;
    }

    public function accept($order)
    {
        if (auth()->user()->type == UserTypes::PUBLIC_DRIVER) {
            request()->request->add(['order_id' => $order->id, 'driver_id' => auth()->user()->id]);
            $this->assignDriver(request());
        }
        if ($order->status == OrderStatus::ASSIGNED || auth()->user()->type == UserTypes::PUBLIC_DRIVER) {
            $driver = $order->drivers->last();

            if (isset($driver) && $driver->id == auth()->id()) {
                $order->driver_id = $driver->id;
                $order->save();

                $orderDriver = DriverOrders::where('order_id', $order->id)->where('driver_id', $driver->id)->get()->last();
                $orderDriver->status = DriverOrderStatus::DRIVER_ACCEPT;
                $orderDriver->start_location = request()->get('lng') . "," . request()->get('lat');
                $orderDriver->save();

                $type = 'driver_accept_order';
                $vendorTitleNotificationMessage = $type;
                $this->orderNotification($order, $vendorTitleNotificationMessage);

                return $orderDriver;
            }
        }

        return false;
    }

    public function cancel($order, $request)
    {
        if ($order->status == OrderStatus::ASSIGNED) {
            $driver = $order->drivers->last();

            if (isset($driver) && $driver->id == auth()->id()) {
                $order->status = OrderStatus::SUBMITTED;
                $order->driver_id = null;
                $order->save();

                $orderDriver = DriverOrders::where('order_id', $order->id)->where('driver_id', $driver->id)->get()->last();
                $orderDriver->status = DriverOrderStatus::DRIVER_CANCELED ;
                $orderDriver->start_location = $request->get('lng').",".$request->get('lat');

                if (auth()->user()->type == UserTypes::DRIVER) {
                    $orderDriver->cancel_reason = $request->get('cancel_reason');
                    if ($request->filled('driver_comment')) {
                        $orderDriver->driver_comment = $request->get('driver_comment');
                    }
                }

                $orderDriver->save() ;

                $type = 'driver_cancel_order';
                $vendorTitleNotificationMessage = $type;
                $this->orderNotification($order, $vendorTitleNotificationMessage);

                return $orderDriver;
            }
        }

        return false;
    }

    public function confirm($order)
    {
        if ($order->status == OrderStatus::DELIVERED) {
            return false;
        }
        if ($order->driver_id == auth()->id() || auth()->user()->type == UserTypes::ADMIN) {
            $order->status = OrderStatus::DELIVERED;

            if ($order->driver_id) {
                $orderDriver = DriverOrders::where('order_id', $order->id)
                    ->where('driver_id', $order->driver_id)
                    ->get()
                    ->last();
                $orderDriver->end_location = request()->input('lng') . "," . request()->input('lat');
                $orderDriver->save();
            }

            if ($order->payment_type == PaymentTypes::CASH_OND_DELIVERY) {
                $orderTotalPrice = $order->total_price ? $order->total_price : 0;
                $amount = $order->final_amount ? $order->final_amount : $orderTotalPrice;
                $paymentData = [
                    'amount' => $amount,
                    'order_id' => $order->id,
                    'status' => PaymentStatus::CONFIRMED,
                ];
                $payment = $this->paymentService->createDraft(request()->replace($paymentData));
                $this->paymentService->updateInvoiceNumber($payment);
            }
            $order->save();

            $this->gainPoints($order);
            $this->accounting($order);

            $type = 'order_delivered';
            $vendorTitleNotificationMessage = $type;
            $clientNotificationTitleMessage = $type;
            $this->orderNotification($order, $vendorTitleNotificationMessage, null, $clientNotificationTitleMessage);

            return $order;
        }

        return false;
    }

    public function validatePromotionCode(Request $request)
    {
        $promotionModel = $this->orderRepository->checkPromotionCodeExists($request);

        if ($promotionModel) {
            if ($promotionModel->segmentation_id && !$this->checkUserBelongsToSegmentation($promotionModel->segmentation_id, auth()->user())) {
                return false;
            }
            if (isset($promotionModel->minimum_order_price) && $promotionModel->minimum_order_price > $request->get('amount')) {
                return -$promotionModel->minimum_order_price;
            }
            if (!isset($promotionModel->minimum_order_price) && $promotionModel->value < $request->get('amount')) {
                return $promotionModel->value."voucher";
            }

            return $this->paymentService->calculateDiscount($request->get('amount'), $promotionModel);
        }

        return false;
    }

    public function applyPromotionCode(Request $request, Order $order)
    {
        $request->request->add(['vendor_id' => $order->branch->vendor->id, 'branch_id' => $order->branch_id]);
        $promotionModel = $this->orderRepository->checkPromotionCodeExists($request);

        if (($promotionModel && !isset($promotionModel->minimum_order_price)) || ($promotionModel && isset($promotionModel->minimum_order_price) && $promotionModel->minimum_order_price <= $this->getOrderTotalCost($order->id))) {
            if ($promotionModel->segmentation_id && !$this->checkUserBelongsToSegmentation($promotionModel->segmentation_id, auth()->user())) {
                return false;
            }
            if (!isset($promotionModel->minimum_order_price) && $promotionModel->value < $this->getOrderTotalCost($order->id)) {
                return false;
            }
            $order->promo_code = $promotionModel->code;
            $order->final_amount = $this->paymentService->calculateDiscount($this->getOrderTotalCost($order->id), $promotionModel) + $this->getOrderDeliveryFee($order);
            $order->save();

            if (isset($promotionModel->minimum_order_price)) { // Coupon code
                $user = User::find($order->user_id);
                $user->coupons()->attach($promotionModel->id);
            } else {                                           // Voucher code
                $promotionModel->is_used = 1;
                $promotionModel->save();
            }
        }
    }

    public function validateUserPoints($points)
    {
        $userPoints = $this->userRepository->getPointsBalance(auth()->user()->id);

        return $userPoints > $points;
    }

    public function redeemPoints($points, $order)
    {
        if ($this->validateUserPoints($points)) {
            $egpToPointsFactor = Setting::where('key', '=', 'POINTS_REDEEM')->first()->value;

            if (!$order->final_amount) {
                $order->final_amount = $this->getOrderTotalCost($order->id) - ($points / $egpToPointsFactor) > 0 ? $this->getOrderTotalCost($order->id) - ($points / $egpToPointsFactor) + $this->getOrderDeliveryFee($order) : 0 + $this->getOrderDeliveryFee($order);
            } else {
                $orderProductCostAfterPromotion = $order->final_amount - $this->getOrderDeliveryFee($order);
                $order->final_amount = $orderProductCostAfterPromotion - ($points / $egpToPointsFactor) > 0 ? $orderProductCostAfterPromotion - ($points / $egpToPointsFactor) + $this->getOrderDeliveryFee($order) : 0 + $this->getOrderDeliveryFee($order);
            }

            $order->points_used = $points;
            $order->save();

            $pointsRequestData = [
                'user_id' => auth()->user()->id,
                'amount' => -$points
            ];
            request()->request->add($pointsRequestData);
            $this->userService->fillUserPoints(request());
        }
        return false;
    }

    public function gainPoints(Order $order, $points = null)
    {
        $pointsToEgpFactor = Setting::where('key', '=', 'POINTS_ACQUIRED')->first()->value;
        $orderAmount = $order->final_amount != null ? $order->final_amount : $order->total_price;

        if (!$points) {
            $points = $orderAmount / $pointsToEgpFactor;
        }
        $pointsRequestData = [
            'user_id' => $order->user_id,
            'amount' => $points
        ];
        request()->request->add($pointsRequestData);
        $this->userService->fillUserPoints(request());
    }

    public function outStock($products)
    {
        $flag = 0;
        foreach ($products as $product) {
            if (isset($product->pivot)) {
                $branchProductId = $product->pivot->branch_product_id;
                $quantity = $product->pivot->quantity;
            } else {
                $branchProductId = $products->branch_product_id;
                $quantity = $products->quantity;
                $flag = 1;
            }
            $branch = Branch::find(BranchProduct::find($branchProductId)->branch_id);
            if ($branch->stock_enabled == 1) {
                $requestData = [
                    'product_id' => $branchProductId,
                    'out_amount' => $quantity,
                    'in_amount' => 0
                ];

                request()->request->add($requestData);
                $this->stockService->fillFromRequest(request());
            }
            if ($flag) {
                break;
            }
        }
    }

    public function inStock($products)
    {
        $flag = 0;
        foreach ($products as $product) {
            if (isset($product->pivot)) {
                $branchProductId = $product->pivot->branch_product_id;
                $quantity = $product->pivot->quantity;
            } else {
                $branchProductId = $products->branch_product_id;
                $quantity = $products->quantity;
                $flag = 1;
            }

            $branch = Branch::find(BranchProduct::find($branchProductId)->branch_id);
            if ($branch->stock_enabled == 1) {
                $requestData = [
                    'product_id' => $branchProductId,
                    'in_amount' => $quantity,
                    'out_amount' => 0,
                ];

                request()->request->add($requestData);
                $this->stockService->fillFromRequest(request());
            }
            if ($flag) {
                break;
            }
        }
    }

    public function calculateOrderLoad($products)
    {
        $load = 0;
        foreach ($products as $product) {
            $load += Product::find($product->product_id)->per_kilogram * $product->pivot->quantity;
        }
        return $load;
    }

    public function calculateExpectedDeliveryTime($order)
    {
        $expectedDeliveryTime = $order->created_at;

        $branch = Branch::find($order->branch_id);
        $branchZone = $branch->zones()
            ->where('branch_zones.zone_id', $order->address->location->id)
            ->get();

        if (count($branchZone)) {
            $branchZoneSLA = $branchZone[0]->pivot->delivery_sla;

            if ($branchZoneSLA < 1) {
                if ($branchZoneSLA == 0.25) {
                    $branchZoneSLA = 15;
                } else {
                    $branchZoneSLA = 30;
                }
                $expectedDeliveryTime = date('Y-m-d H:i:s', strtotime($expectedDeliveryTime. ' + '.$branchZoneSLA.' minutes'));
            } else {
                $startWorking = date('Y-m-d' . ' ' . $branch->start_working_hours);
                $endWorking = date('Y-m-d' . ' ' . $branch->end_working_hours);

                $expectedDeliveryTime = date('Y-m-d H:i:s', strtotime($expectedDeliveryTime . ' + ' . $branchZoneSLA . ' hours'));

                if ($startWorking < $order->created_at && $order->created_at < $endWorking) {
                    if ($expectedDeliveryTime > $endWorking) {
                        $diff_in_hours = Carbon::parse($expectedDeliveryTime)->diffInHours(Carbon::parse($endWorking)) + 24;
                        $expectedDeliveryTime = date('Y-m-d H:i:s', strtotime($startWorking . ' + ' . $diff_in_hours . ' hours'));
                    }
                } elseif ($startWorking > $order->created_at) {
                    $expectedDeliveryTime = date('Y-m-d H:i:s', strtotime($startWorking . ' + ' . $branchZoneSLA . ' hours'));
                } else {
                    $branchZoneSLA += 24;
                    $expectedDeliveryTime = date('Y-m-d H:i:s', strtotime($startWorking . ' + ' . $branchZoneSLA . ' hours'));
                }
            }
        }

        return $expectedDeliveryTime;
    }

    public function checkUserBelongsToSegmentation($segmentationID, $user)
    {
        $segmentation = Segmentation::find($segmentationID);
        $users = $this->segmentationRepository->getSegmentationUsers($segmentation);
        if ($users->contains('id', $user->id)) {
            return true;
        }
        return false;
    }

    public function validateOrderAmount(Request $request)
    {
        $minOrderAmount = Branch::find($request->get('branch'))->min_order_amount;
        return $minOrderAmount <= $request->get('amount');
    }

    public function getOrderDeliveryFee($order)
    {
        $zone = Location::find(Address::find($order->address_id)->location_id)->id;
        try {
            return BranchZone::where('branch_id', $order->branch_id)
                ->where('zone_id', $zone)
                ->first()
                ->delivery_fee;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getOrderAykhedmaFee($order)
    {
        try {
            return $this->getOrderTotalCost($order->id) * (Branch::find($order->branch_id)->aykhedma_fee/100) ;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getCouponDiscount($order)
    {
        if ($order->promo_code) {
            $promo = Coupon::where('code', $order->promo_code)->first();
            if (!$promo) {
                $promo = Voucher::where('code', $order->promo_code)->first();
            }

            if ($promo) {
                $amountAfterDiscount = $this->paymentService->calculateDiscount($this->getOrderTotalCost($order->id), $promo);

                if (!$promo->vendor_id) {
                    return $this->getOrderTotalCost($order->id) - $amountAfterDiscount;
                }

                return -($this->getOrderTotalCost($order->id) - $amountAfterDiscount);
            }
        }

        return false;
    }

    public function getPointsDiscount($order)
    {
        $points = $order->points_used;
        $egpToPointsFactor = Setting::where('key', '=', 'POINTS_REDEEM')->first()->value;

        return $points/$egpToPointsFactor;
    }

    public function accounting($order)
    {
        $aykedmaFee = $this->getOrderAykhedmaFee($order);
        $branchId = $order->branch_id;
        $driver = User::find($order->driver_id);

        if ($this->getCouponDiscount($order) > 0) { //coupon belongs to ai5edma
            $aykedmaFee -= round($this->getCouponDiscount($order), 2);
        }
        if ($order->points_used) {
            $aykedmaFee -= round($this->getPointsDiscount($order), 2);
        }

        if ($order->payment_type == PaymentTypes::CASH_OND_DELIVERY) {
            $transactionsData = [
                [
                    'account_id' => 1,
                    'account_type' => 'user',
                    'credit' => $aykedmaFee,
                    'debit' => 0,
                    'order_id' => $order->id,
                    'transaction_type' => TransactionTypes::COMMISSION,
                ],
                [
                    'account_id' => $branchId,
                    'account_type' => 'branch',
                    'credit' => 0,
                    'debit' => $aykedmaFee,
                    'order_id' => $order->id,
                    'transaction_type' => TransactionTypes::COMMISSION,
                ],
            ];
            foreach ($transactionsData as $transactionData) {
                request()->request->add($transactionData);
                $this->transactionService->fillFromRequest(request());
            }
        }
        if ($order->payment_type == PaymentTypes::ONLINE_PAYMENT) {
            $productsAmount = $this->getOrderTotalCost($order->id);
            $deliveryFee = $this->getOrderDeliveryFee($order);
            if ($this->getCouponDiscount($order) < 0) { //coupon belongs to vendor
                $productsAmount -= (round($this->getCouponDiscount($order), 2)*-1);
            }
            $orderAmount = $order->final_amount ?? $order->total_price;
            $thirdPartyCharge =  $orderAmount * (Setting::where('key', '=', 'VISA_CHARGE')->first()->value/100);

            $transactionsData = [
                [
                    'account_id' => $order->user_id,
                    'account_type' => 'user',
                    'credit' => 0,
                    'debit' => $order->final_amount ?? $order->total_price,
                    'order_id' => $order->id,
                    'transaction_type' => TransactionTypes::ONLINE_TRANSFER,
                ],
                [
                    'account_id' => 1,
                    'account_type' => 'user',
                    'credit' => $aykedmaFee - $thirdPartyCharge ,
                    'debit' => 0,
                    'order_id' => $order->id,
                    'transaction_type' => TransactionTypes::COMMISSION,
                ],
                [
                    'account_id' => $branchId,
                    'account_type' => 'branch',
                    'credit' => $productsAmount - $aykedmaFee,
                    'debit' => 0,
                    'order_id' => $order->id,
                    'transaction_type' => TransactionTypes::PRODUCT_COST,
                ],
            ];

            if ($driver->type == UserTypes::DRIVER) {
                $transactionsData [] = [
                    'account_id' => $branchId,
                    'account_type' => 'branch',
                    'credit' => $deliveryFee,
                    'debit' => 0,
                    'order_id' => $order->id,
                    'transaction_type' => TransactionTypes::DELIVERY_CHARGE,
                ];
            }
            if ($driver->type == UserTypes::PUBLIC_DRIVER) {
                $transactionsData [] = [
                    'account_id' => $driver->id,
                    'account_type' => 'user',
                    'credit' => $deliveryFee,
                    'debit' => 0,
                    'order_id' => $order->id,
                    'transaction_type' => TransactionTypes::DELIVERY_CHARGE,
                ];
            }

            foreach ($transactionsData as $transactionData) {
                request()->request->add($transactionData);
                $this->transactionService->fillFromRequest(request());
            }
        }
    }

    public function submitOrderAccountingOnline($order)
    {
        $orderAmount = $order->final_amount ?? $order->total_price;
        $thirdPartyCharge =  $orderAmount * (Setting::where('key', '=', 'VISA_CHARGE')->first()->value/100);
        $aykhedmaDebit = $orderAmount - $thirdPartyCharge;

        $transactionsData = [
            [
                'account_id' => $order->user_id,
                'account_type' => 'user',
                'credit' => $order->final_amount ?? $order->total_price,
                'debit' => 0,
                'order_id' => $order->id,
                'transaction_type' => TransactionTypes::ONLINE_TRANSFER,
            ],
            [
                'account_id' => 1,
                'account_type' => 'user',
                'credit' => 0,
                'debit' => $aykhedmaDebit,
                'order_id' => $order->id,
                'transaction_type' => TransactionTypes::ONLINE_TRANSFER,
            ],
            [
                'account_id' => 2,
                'account_type' => 'user',
                'credit' => 0,
                'debit' => $thirdPartyCharge,
                'order_id' => $order->id,
                'transaction_type' => TransactionTypes::ONLINE_TRANSFER,
            ],
        ];
        foreach ($transactionsData as $transactionData) {
            request()->request->add($transactionData);
            $this->transactionService->fillFromRequest(request());
        }
    }

    public function cancelOrderAccountingOnline($order)
    {
        $orderAmount = $order->final_amount ?? $order->total_price;
        $thirdPartyCharge =  $orderAmount * (Setting::where('key', '=', 'VISA_CHARGE')->first()->value/100);
        $thirdPartyCancellationCharge =  $orderAmount * (Setting::where('key', '=', 'VISA_CANCELLATION_CHARGE')->first()->value/100);
        $aykhedmaCredit = $orderAmount - $thirdPartyCharge;
        $transactionsData = [
            [
                'account_id' => $order->user_id,
                'account_type' => 'user',
                'credit' => 0,
                'debit' => $orderAmount - $thirdPartyCancellationCharge - $thirdPartyCharge,
                'order_id' => $order->id,
                'transaction_type' => TransactionTypes::ONLINE_TRANSFER,
            ],
            [
                'account_id' => 1,
                'account_type' => 'user',
                'credit' => $aykhedmaCredit,
                'debit' => 0,
                'order_id' => $order->id,
                'transaction_type' => TransactionTypes::ONLINE_TRANSFER,
            ],
            [
                'account_id' => 2,
                'account_type' => 'user',
                'credit' => 0,
                'debit' => $thirdPartyCancellationCharge,
                'order_id' => $order->id,
                'transaction_type' => TransactionTypes::ONLINE_TRANSFER,
            ],
        ];
        foreach ($transactionsData as $transactionData) {
            request()->request->add($transactionData);
            $this->transactionService->fillFromRequest(request());
        }
    }

    public function getOrderVendorAdmins($order)
    {
        return $order->branch->vendor->admins->whereIn('branch_id', [$order->branch_id, null]);
    }

    public function orderNotification($order, $vendorNotificationTitleMessage = null, $clientMailable = null, $clientNotificationTitleMessage = null)
    {
        dispatch(new OrderNotification($order, $vendorNotificationTitleMessage));

        if ($clientNotificationTitleMessage) {
            $messageData["title"] = $clientNotificationTitleMessage;
            $messageData["body"] = $order;
            $this->notificationService->sendPush($order->user, $messageData);
        }
        if ($clientMailable) {
            $this->notificationService->sendMail($order->user, $clientMailable);
        }
    }

    public function setShipmentCapacity($shipment)
    {
        $shipment->load = 0;

        foreach ($shipment->orders as $order) {
            $shipment->load += $this->calculateOrderLoad($order->products);
            $shipment->save();
        }
    }

    public function setParentShipmentCapacity($parentShipment)
    {
        $parentShipment->load = 0;
        foreach ($parentShipment->children as $shipment) {
            $parentShipment->load += $shipment->load;
        }
        $parentShipment->save();
    }

    public function userHasAccess($order)
    {
        if (Permissible::where('user_id', auth()->user()->id)->where('permissible_type', 'App\Models\Branch')->first()) {
            if(Permissible::where('user_id', auth()->user()->id)->where('permissible_id', $order->branch_id)->where('permissible_type', 'App\Models\Branch')->first()) {
                return true;
            }
            return false;
        }
        return true;
    }
}
