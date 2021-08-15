<?php

namespace App\Repositories;

use App\Models\Shipment ;

class ShipmentRepository
{
    public function searchFromRequest($request)
    {
        $shipments = Shipment::orderBy('id', 'DESC')
            ->when($request->get('active') != '', function ($shipments) use ($request) {
                return $shipments->where('active', '=', $request->get('active'));
            })
            ->when($request->get('title'), function ($shipments) use ($request) {
                $shipments->whereHas('translations', function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->query->get('title') . '%');
                });
            })
            ->when($request->get('parent_id'), function ($shipments) use ($request) {
                return $shipments->where('parent_id', '=', $request->get('parent_id'));
            });

            if ($request->filled('id')) {
                $shipments->where('id', $request->get("id"));
            }
        if ($request->filled('type')) {
            if ($request->get("type") == 1) {
                $shipments->where('parent_id', null);
            }
            if ($request->get("type") == 2) {
                $shipments->where('parent_id', '<>', null);
            }
        }
        return $shipments;
    }
}
