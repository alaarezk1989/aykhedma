<?php

namespace App\Http\Services;

use App\Constants\DriverOrderStatus;
use App\Constants\OrderStatus;
use App\Http\Resources\ActualShipments;
use App\Http\Resources\Shipments;
use App\Jobs\CreateShipmentNotification;
use App\Mail\CreateNewShipmentMail;
use App\Models\ActualShipment;
use App\Models\Address;
use App\Models\DriverOrders;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\Vehicle;
use App\Repositories\ShipmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Maatwebsite\Excel\Facades\Excel;

class ShipmentService
{
    protected $notificationService;
    protected $shipmentRepository;

    public function __construct(NotificationService $notificationService, ShipmentRepository $shipmentRepository)
    {
        $this->notificationService = $notificationService;
        $this->shipmentRepository = $shipmentRepository;
    }

    public function fillFromRequest(Request $request, $shipment = null)
    {
        $flag = "update";
        if (!$shipment) {
            $flag = "new";
            $shipment = new Shipment();
        }

        $shipment->fill($request->request->all());
        $shipment->recurring = $request->request->get('recurring', 0);
        $shipment->active = $request->request->get('active', 0);

        $vehicle = Vehicle::find($request->get('vehicle_id'));
        $shipment->capacity = $vehicle->capacity;
        if (!$request->filled('day')) {
            $shipment->day = 1;
        }

        if ($request->filled('region_id') || $request->filled('district_id')) {
            $address = new Address();
            if ($request->filled('region_id')) {
                $address->location_id = $request->get('region_id');
            }
            if ($request->filled('district_id')) {
                $address->location_id = $request->get('district_id');
            }
            $address->save();
            $shipment->one_delivery_address_id = $address->id;
        }
        $shipment->save();

        if ($flag == "update") {
            $actualShipments = ActualShipment::where('shipment_id', $shipment->id)->get();
            foreach ($actualShipments as $actualShipment) {
                if (!$this->actualShipmentHasOrders($actualShipment)) {
                    $actualShipment->branch_id = $shipment->branch_id;
                    $actualShipment->from = $shipment->from;
                    $actualShipment->to = $shipment->to;
                    $actualShipment->status = $shipment->status;
                    $actualShipment->one_address = $shipment->one_address;
                    $actualShipment->one_delivery_address_id = $shipment->one_delivery_address_id;
                }
                $actualShipment->translate('en')->title = $shipment->translate('en')->title;
                $actualShipment->translate('ar')->title = $shipment->translate('ar')->title;
                $actualShipment->capacity = $shipment->capacity;
                $actualShipment->vehicle_id = $shipment->vehicle_id;
                $actualShipment->driver_id = $shipment->driver_id;

                if($shipment->wasChanged('driver_id')) {
                    $this->setOrderShipmentDriver($actualShipment);
                }


                $actualShipment->save();
            }
        }

        dispatch(new CreateShipmentNotification($shipment));

        return $shipment;
    }

    public function calculateChildrenCapacity(Shipment $shipment)
    {
        return  Shipment::where('parent_id', $shipment->id)->sum('capacity');
    }

    public function validateSubShipmentTime($subFromTime, $parentToTime)
    {
        if ($subFromTime < $parentToTime) {
            return false;
        }
        return true;
    }

    public function export()
    {
        $headings = [
            [trans('shipments_list')],
            [
                '#',
                trans('title'),
                trans('type'),
                trans('parent_id'),
                trans('from_address'),
                trans('to_address'),
                trans('recurring'),
                trans('day'),
                trans('from_date'),
                trans('to_date'),
                trans('vehicle'),
                trans('driver'),
                trans('delivery_person'),
                trans('capacity'),
                trans('load'),
            ]
        ];
        $list = $this->shipmentRepository->searchFromRequest(request())->get();
        $listObjects = Shipments::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Shipments Report.xlsx');
    }

    public function actualShipmentHasOrders($actualShipment)
    {
        return Order::query()->where('shipment_id', $actualShipment->id)->first();
    }

    public function setOrderShipmentDriver($shipment)
    {
        $shipmentOrders = Order::where('shipment_id', $shipment->id)
            ->whereIn('status', [OrderStatus::ASSIGNED, OrderStatus::SUBMITTED])
            ->get();

        foreach ($shipmentOrders as $order) {
            $order->status = OrderStatus::ASSIGNED;
            $order->driver_id = $shipment->driver_id;
            $order->save();

            $orderDriver = new DriverOrders();
            $orderDriver->order_id = $order->id;
            $orderDriver->driver_id = $shipment->driver_id;
            $orderDriver->status = DriverOrderStatus::DRIVER_ACCEPT;
            $orderDriver->save();
        }
    }
}
