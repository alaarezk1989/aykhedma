<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GroupPermission;
use App\Constants\UserTypes;

use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPermissionPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        // check if the user is not admin return false before access any rolls
        if (!$user->isTypeOf(UserTypes::ADMIN)) {
            return false;
        }
    }

    public function index(User $user)
    {
        return $user->hasAccess("admin.group.permissions.index");
    }

    public function create(User $user)
    {
        return $user->hasAccess("admin.group.permissions.create");
    }

    public function update(User $user, GroupPermission $groupPermission)
    {
        return $user->hasAccess("admin.group.permissions.update");
    }

    public function delete(User $user, GroupPermission $groupPermission)
    {
        return $user->hasAccess("admin.group.permissions.destroy");
    }
}
