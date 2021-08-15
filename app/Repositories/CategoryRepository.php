<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function searchFromRequest($request)
    {
        $categories = Category::orderBy('id', 'DESC')
            ->when($request->get('active'), function ($categories) use ($request) {
                return $categories->where('active', '=', $request->get('active'));
            })
            ->when($request->get('parent_id'), function ($categories) use ($request) {
                return $categories->where('parent_id', '=', $request->get('parent_id'));
            }, function ($categories) use ($request) {
                return $categories->where('parent_id', '=', null);
            });

        if ($request->has('name') && !empty($request->get('name'))) {
            $categories->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('name') . '%');
            });
        }

        return $categories;
    }
}
