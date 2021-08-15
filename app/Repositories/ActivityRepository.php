<?php

namespace App\Repositories;

use App\Models\Activity;

class ActivityRepository
{
    public function searchFromRequest($request)
    {
        $activities = Activity::orderBy('id', 'DESC');
        if ($request->has('name') && !empty($request->get('name'))) {
            $activities->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('name') . '%');
            });
        }
        return $activities;
    }

}