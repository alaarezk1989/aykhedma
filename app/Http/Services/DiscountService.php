<?php

namespace App\Http\Services;

use App\Models\Discount;
use Symfony\Component\HttpFoundation\Request;

class DiscountService
{

    public function fillFromRequest(Request $request, $discount = null)
    {
        if (!$discount) {
            $discount = new Discount();
        }

        $discount->fill($request->request->all());
        $discount->active = $request->request->get('active', 0);
        $discount->save();

        return $discount;
    }
}
