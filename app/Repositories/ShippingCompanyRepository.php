<?php

namespace App\Repositories;

use App\Models\ShippingCompany;

class ShippingCompanyRepository
{
  public function searchFromRequest($request)
    {
        $shippingCompanies = ShippingCompany::orderBy('id', 'DESC');
        if ($request->has('name') && !empty($request->get('name'))) {
            $shippingCompanies->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('name') . '%');
            });
        }
        return $shippingCompanies;
    }

}