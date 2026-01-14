<?php

namespace App\Repositories;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountRepository
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function searchFromRequest(Request $request)
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
