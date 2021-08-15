<?php

namespace App\Repositories;

use App\Models\Vehicle;
use Symfony\Component\HttpFoundation\Request;

class VehicleRepository
{
    /**
     * @param $request
     * @return $this|mixed
     */
    public function search(Request $request)
    {
        $vehicles = Vehicle::orderBy('id', 'DESC');

        if ($request->has('type') && !empty($request->get('type'))) {
            $vehicles->where('type_id', $request->query->get('type'));

        };

        if ($request->has('driver') && !empty($request->get('driver'))) {
            $vehicles->where('driver_id', $request->get('driver'));
        }
        
        if ($request->has('status') && !empty($request->get('status'))) {
            $vehicles->where('status_id', $request->get('status'));
        }
        if ($request->has('active') && !empty($request->get('active'))) {
            $vehicles->where('active', $request->get('active'));
        }
        
        return $vehicles;
    }
}
