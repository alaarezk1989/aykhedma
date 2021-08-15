<?php

namespace App\Http\Services;

use App\Models\ShippingCompany;
use Symfony\Component\HttpFoundation\Request;


class ShippingCompanyService
{

    public function fillFromRequest(Request $request, $shippingCompany = null)
    {
        if (!$shippingCompany) {
            $shippingCompany = new ShippingCompany();
        }

        $shippingCompany->fill($request->request->all());
        $shippingCompany->active = $request->request->get('active', 0);

        $shippingCompany->save();

        return $shippingCompany;
    }
}
