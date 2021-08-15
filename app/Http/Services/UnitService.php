<?php

namespace App\Http\Services;

use App\Models\Unit;
use Symfony\Component\HttpFoundation\Request;

class UnitService
{
    public function fillFromRequest(Request $request, $unit = null)
    {
        if (!$unit ){
            $unit = new Unit();
        }
      
        $unit->fill($request->request->all());
        $unit->active = $request->request->get('active', 0);
        $unit->save();

        return $unit;
    }
}
