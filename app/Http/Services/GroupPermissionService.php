<?php

namespace App\Http\Services;

use Symfony\Component\HttpFoundation\Request;

class GroupPermissionService
{

    public function fillFromRequest(Request $request, $group = null)
    {
        if (!$group) {
            return false;
        }
        $group->permissions()->sync($request->input("permissions"));
        return $group;
    }
}
