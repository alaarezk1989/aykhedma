<?php

namespace App\Http\Services;

use App\Constants\ActualShipmentStatus;
use App\Constants\DriverOrderStatus;
use App\Constants\OrderStatus;
use App\Constants\RecurringTypes;
use App\Constants\WeekDays;
use App\Http\Resources\ActualShipments;
use App\Models\ActualShipment;
use App\Models\DriverOrders;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\Vehicle;
use App\Repositories\ActualShipmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ActualShipmentService
{
    private $actualShipmentRepository;

    public function __construct(ActualShipmentRepository $actualShipmentRepository)
    {
        $this->actualShipmentRepository = $actualShipmentRepository;
    }

    public function fillFromRequest(Request $request, $actualShipment = null)
    {
        if (!$actualShipment) {
            $actualShipment = new ActualShipment();
        }

        $actualShipment->fill($request->request->all());
        $actualShipment->active = $request->request->get('active', 0);

        if ($request->isMethod('post')) {
            $actualShipment->cutoff = $request->request->get('cutoff') . " " . $request->request->get('cutoff_time');
            $actualShipment->from_time = $request->request->get('from_time') . " " . $request->request->get('from_hour');
            $actualShipment->to_time = $request->request->get('to_time') . " " . $request->request->get('to_hour');
        }
        $vehicle = Vehicle::find($request->get('vehicle_id'));
        $actualShipment->capacity = $vehicle->capacity;

        $actualShipment->save();

        if (!$request->isMethod('post') && $actualShipment->wasChanged('driver_id')) {
            $this->setOrderShipmentDriver($actualShipment);
        }

        return $actualShipment;
    }

    public function createActualShipments(Request $request)
    {
        $shipments = Shipment::query()->where('active', 1)
            ->OrderBy('id', 'ASC')
            ->get();

        foreach ($shipments as $shipment) {
            $requestData = [
                'branch_id' => $shipment->branch_id,
                'shipment_id' => $shipment->id,
                'vehicle_id' => $shipment->vehicle_id,
                'driver_id' => $shipment->driver_id,
                'from' => $shipment->from,
                'to' => $shipment->to,
                'one_address' => $shipment->one_address,
                'one_delivery_address_id' => $shipment->one_delivery_address_id,
                'capacity' => $shipment->capacity,
                'active' => $shipment->active,
                'status' => ActualShipmentStatus::SUBMITTED,
                'en' => ['title' => $shipment->translate('en')->title],
                'ar' => ['title' => $shipment->translate('ar')->title],
            ];

            $fromTime = '';
            $toTime = '';

            for ($i = 0; $i < $shipment->recurring; $i++) {
                $request = new Request();
                if ($shipment->recurring == RecurringTypes::DAILY) {
                    $from = $i == 0 ? date('Y-m-d' . ' ' . $shipment->from_time) : $fromTime;
                    $to = $i == 0 ? date('Y-m-d' . ' ' . $shipment->to_time) : $toTime;

                    $fromTime = date('Y-m-d H:i:s', strtotime($from . ' + 1 days'));
                    $toTime = date('Y-m-d H:i:s', strtotime($to . ' + 1 days'));
                }
                if ($shipment->recurring == RecurringTypes::WEEKLY) {
                    $from = $fromTime = $i == 0 ? Carbon::parse('next ' . WeekDays::getDay($shipment->day) . '')->toDateString() . ' ' . $shipment->from_time : $fromTime;
                    $to = $toTime = $i == 0 ? Carbon::parse('next ' . WeekDays::getDay($shipment->day) . '')->toDateString() . ' ' . $shipment->to_time : $toTime;

                    if ($i != 0) {
                        $fromTime = date('Y-m-d H:i:s', strtotime($from . ' + 7 days'));
                        $toTime = date('Y-m-d H:i:s', strtotime($to . ' + 7 days'));
                    }
                }
                if ($shipment->recurring == RecurringTypes::MONTHLY) {
                    $fromTime = date('Y-m-d H:i:s', strtotime($fromTime . ' + 1 month'));
                    $toTime = date('Y-m-d H:i:s', strtotime($toTime . ' + 1 month'));

                    if ($i == 0) {
                        $fromTime = date('Y-m-d H:i:s', strtotime(date('Y-m-' . $shipment->day . ' ' . $shipment->from_time . '') . ' + 1 month'));
                        $toTime = date('Y-m-d H:i:s', strtotime(date('Y-m-' . $shipment->day . ' ' . $shipment->to_time . '') . ' + 1 month'));

                        if (date('Y-m-d') > date('Y-m-' . $shipment->day . '')) {
                            $fromTime = date('Y-m-' . $shipment->day . ' ' . $shipment->from_time . '');
                            $toTime = date('Y-m-' . $shipment->day . ' ' . $shipment->to_time . '');
                        }
                    }
                }
                if ($shipment->recurring == RecurringTypes::ONE_TIME) {
                    $fromTime = $i == 0 ? Carbon::parse('next ' . WeekDays::getDay($shipment->day) . '')->toDateString() . ' ' . $shipment->from_time : $fromTime;
                    $toTime = $i == 0 ? Carbon::parse('next ' . WeekDays::getDay($shipment->day) . '')->toDateString() . ' ' . $shipment->to_time : $toTime;
                    $i = 3;
                    $shipment->active = 0;
                }

                if ($this->actualShipmentRepository->checkDateExists($shipment, $fromTime)) {
                    continue;
                }

                $cutoff = date('Y-m-d H:i:s', strtotime($fromTime . ' - ' . $shipment->cut_off_date . ' hours'));
                $requestData['from_time'] = $fromTime;
                $requestData['to_time'] = $toTime;
                $requestData['cutoff'] = $cutoff;

                if ($shipment->parent_id != null) {
                    $requestData['parent_id'] = $this->getParentActualShipment($shipment, $cutoff);
                }

                $request->request->add($requestData);
                $this->fillFromRequest($request);
            }

            $shipment->save();
        }
    }

    public function calculateChildrenCapacity(ActualShipment $actualShipment)
    {
        return  ActualShipment::where('parent_id', $actualShipment->id)->sum('capacity');
    }

    public function getParentActualShipment($shipment, $cutoff)
    {
        if ($shipment->parent_id) {
            $actualShipment =  ActualShipment::where('shipment_id', $shipment->parent_id)
                //->where('to', $shipment->from)
                ->whereDate('cutoff', date('Y-m-d', strtotime($cutoff)))
                ->first();
            if ($actualShipment) {
                return $actualShipment->id;
            }
        }
        return null;
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
            [trans('actual_shipments_list')],
            [
                '#',
                trans('title'),
                trans('type'),
                trans('parent_id'),
                trans('from_address'),
                trans('to_address'),
                trans('from_date'),
                trans('to_date'),
                trans('cutoff'),
                trans('vehicle'),
                trans('driver'),
                trans('delivery_person'),
                trans('capacity'),
                trans('load'),
            ]
        ];
        $list = $this->actualShipmentRepository->searchFromRequest(request())->get();
        $listObjects = ActualShipments::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Actual Shipments Report.xlsx');
    }
}
