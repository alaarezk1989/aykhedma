<?php

namespace App\Repositories;

use App\Models\Group;
use Symfony\Component\HttpFoundation\Request;

class GroupRepository
{
    public function search(Request $request)
    {
        $groups = Group::query()->where('type', 0)->orderByDesc("id");

        if ($request->has('name') && !empty($request->get('name'))) {
            $groups->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('name') . '%');
            });
        }

        return $groups;
    }
}
