<?php

namespace App\Http\Services;

use App\Models\Company;
use Symfony\Component\HttpFoundation\Request;

class CompanyService
{
    public function fillFromRequest(Request $request, $company = null)
    {
        if (!$company) {
            $company = new Company();
        }

        $company->fill($request->request->all());
        $company->save();

        return $company;
    }
}
