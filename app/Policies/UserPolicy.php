<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the unit index.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        // check if the user is not admin return false before access any rolls
        if (!$user->isTypeOf(UserTypes::ADMIN) && !$user->isTypeOf(UserTypes::VENDOR)) {
            return false;
        }
    }

    /**
     * Determine whether the user can view the  index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.users.index");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.staff.index");
        }
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.users.create");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.staff.create");
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.users.update");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.staff.update");
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.users.destroy");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.staff.destroy");
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public function userGroupsIndex(User $user)
    {
        return $user->hasAccess("admin.users.groups.index");
    }

    public function driverSettle(User $user)
    {
        return $user->hasAccess("admin.users.settle");
    }
}
