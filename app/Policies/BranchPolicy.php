<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the branch index.
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
     * Determine whether the user can view the branch index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branches.index");
        }

        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.branches.index");
        }
    }

    /**
     * Determine whether the user can create branches.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branches.create");
        }

        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.branches.create");
        }
    }

    /**
     * Determine whether the user can update the branch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Branch  $branch
     * @return mixed
     */
    public function update(User $user, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branches.update", $branch);
        }

        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.branches.update");
        }
    }

    /**
     * Determine whether the user can delete the branch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Branch  $branch
     * @return mixed
     */
    public function delete(User $user, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branches.destroy", $branch);
        }

        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.branches.destroy");
        }
    }
}
