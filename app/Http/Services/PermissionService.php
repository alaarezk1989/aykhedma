<?php

namespace App\Http\Services;

use App\Models\Permission;
use Symfony\Component\HttpFoundation\Request;

class PermissionService
{

    public function fillFromRequest(Request $request, $permission = null)
    {
        if (!$permission) {
            $permission = new Permission();
        }

        $permission->fill($request->request->all());
        $permission->active = $request->request->get('active', 0);
        $permission->save();

        return $permission;
    }

}
