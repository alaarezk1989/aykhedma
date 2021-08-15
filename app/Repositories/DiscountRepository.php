<?php

namespace App\Repositories;

use App\Models\Discount;

class DiscountRepository
{
    public function searchFromRequest($request)
    {
        $discounts = Discount::orderBy('id', 'DESC');
        if ($request->has('title') && !empty($request->get('title'))) {
            $discounts->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->query->get('title') . '%');
            });
        }
        return $discounts;
    }

}
