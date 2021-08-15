<?php

namespace App\Http\Services;

use App\Models\Group;
use Symfony\Component\HttpFoundation\Request;

class GroupService
{

    public function fillFromRequest(Request $request, $group = null)
    {
        if (!$group) {
            $group = new Group();
        }
        $group->fill($request->request->all());
        $group->active = $request->input("active", 0);
        $group->save();
        return $group;
    }

}
