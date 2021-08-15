<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function search($request)
    {
        $company = Company::orderBy('id', 'DESC')
            ->when($request->get('name'), function ($company) use ($request) {
                return $company->whereHas('translations', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->query->get('name') . '%');
                });
            });


        return $company;
    }
}
