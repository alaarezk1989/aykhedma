<?php

namespace App\Repositories;

use App\Models\Permission;
use Symfony\Component\HttpFoundation\Request;

class PermissionRepository
{
    public function search(Request $request)
    {
        $permission = Permission::query()->orderByDesc("id");

        if ($request->has('name') && !empty($request->get('name'))) {
            $permission->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query->get('name') . '%');
            });
        }

        return $permission;
    }
}
