<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDevicePolicy
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
        if (!$user->isTypeOf(UserTypes::ADMIN)) {
            return false;
        }
    }

    /**
     * Determine whether the user can view the index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.user.devices.index");
    }


    /**
     * Determine whether the user can create user devices.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.user.devices.create");
    }


    /**
     * Determine whether the user can delete the user devices.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserDevice  $userDevice
     * @return mixed
     */
    public function delete(User $user, UserDevice $userDevice)
    {
        return $user->hasAccess("admin.user.devices.destroy");
    }
}
