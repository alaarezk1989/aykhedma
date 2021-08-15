<?php

namespace App\Http\Services;

use App\Models\Vehicle;
use Symfony\Component\HttpFoundation\Request;

class VehicleService
{
    public function fillFromRequest(Request $request, $vehicle = null)
    {
        if (!$vehicle) {
            $vehicle = new Vehicle();
        }

        $vehicle->fill($request->request->all());
        $vehicle->active = $request->request->get('active', 0);
        $vehicle->save();

        return $vehicle;
    }
}
