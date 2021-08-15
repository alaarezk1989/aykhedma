<?php

namespace App\Repositories;

use App\Models\Unit;
use Symfony\Component\HttpFoundation\Request;

class UnitRepository
{
    public function search(Request $request)
    {
        $units = Unit::query()->orderByDesc("id");

        if ($request->has('name') && !empty($request->get('name'))) {
            $units->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('name') . '%');
            });
        }

        return $units;
    }
}
