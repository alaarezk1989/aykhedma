<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use App\Constants\UserTypes;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if (!$user->isTypeOf(UserTypes::ADMIN)) {
            return false;
        }
    }

    public function index(User $user)
    {
        return $user->hasAccess("admin.groups.index");
    }

    public function create(User $user)
    {
        return $user->hasAccess("admin.groups.create");
    }

    public function update(User $user, Group $group)
    {
        return $user->hasAccess("admin.groups.update");
    }

    public function delete(User $user, Group $group)
    {
        return $user->hasAccess("admin.groups.destroy");
    }
}
