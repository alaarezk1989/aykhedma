<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\CancelReason;
use Illuminate\Auth\Access\HandlesAuthorization;

class CancelReasonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the CancelReason index.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        // check if the user is not admin return false before access any rolls
        if (!$user->isTypeOf(UserTypes::ADMIN)) {
            return false;
        }
    }

    /**
     * Determine whether the user can view the CancelReason index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.cancelReasons.index");
    }

    /**
     * Determine whether the user can create cancelReasons.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.cancelReasons.create");
    }

    /**
     * Determine whether the user can update the CancelReason.
     *
     * @param \App\Models\User $user
     * @param \App\Models\CancelReason $cancelReason
     * @return mixed
     */
    public function update(User $user, CancelReason $cancelReason)
    {
        return $user->hasAccess("admin.cancelReasons.update");
    }
}
