<?php

namespace App\Repositories;

use App\Models\ActualShipment;
use Carbon\Carbon;
use DB;
use App\Constants\ActualShipmentStatus;

class ActualShipmentRepository
{
    public function searchFromRequest($request)
    {
        $trips = ActualShipment::orderBy('id', 'DESC');

        if ($request->filled('id')) {
            $trips->where('id', $request->get("id"));
        }
        if ($request->filled('title')) {
            $trips->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->query->get('title') . '%');
            });
        }
        if ($request->filled('active')) {
            $trips->where('active', $request->get('active'));
        }
        if ($request->filled('type')) {
            if ($request->get("type") == 1) {
                $trips->where('parent_id', null);
            }
            if ($request->get("type") == 2) {
                $trips->where('parent_id', '<>', null);
            }
        }
        if ($request->filled('from_time')) {
            $trips->where('to_time', '>=', $request->get('from_time'));
        }
        if ($request->filled('to_time')) {
            $trips->where('to_time', '<=', $request->get('to_time'));
        }

        return $trips;
    }

    public function checkDateExists($shipment, $fromDate)
    {
        return ActualShipment::where('shipment_id', $shipment->id)->where('from_time', $fromDate)->first();
    }

    public function getTimeSlots($userAddress, $branchId, $load)
    {
        $nextWeek = new Carbon();
        $nextWeek->addDays(5);

        return ActualShipment::orderBy('cutoff', 'ASC')
            ->whereRaw('actual_shipments.capacity > actual_shipments.load')
            ->whereRaw('actual_shipments.capacity - actual_shipments.load >= '.$load.'')
            ->where('branch_id', '=', $branchId)
            ->where('active', 1)
            ->where('parent_id', '<>', null)
            ->where('to', $userAddress)
            ->where('cutoff', '>', carbon::now())
            ->where('to_time', '<=', $nextWeek);

    }

    public function getAvailableDeletedActualShipment($shipment)
    {
        $list = ActualShipment::where('shipment_id', $shipment->id)->doesntHave('orders')->get();

        return $list;
    }
}
