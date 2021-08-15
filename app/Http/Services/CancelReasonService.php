<?php

namespace App\Http\Services;

use App\Models\CancelReason;
use Symfony\Component\HttpFoundation\Request;

class CancelReasonService
{
    public function fillFromRequest(Request $request, $cancelReason = null)
    {
        if (!$cancelReason) {
            $cancelReason = new CancelReason();
        }
        $cancelReason->fill($request->request->all());
        $cancelReason->active = $request->request->get('active', 0);
        $cancelReason->save();

        return $cancelReason;
    }
}
