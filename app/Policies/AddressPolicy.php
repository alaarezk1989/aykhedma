<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
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
     * Determine whether the user can view the unit index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.user.addresses.index");
    }

    /**
     * Determine whether the user can create addresses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.user.addresses.create");
    }

    /**
     * Determine whether the user can update the address.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\address  $address
     * @return mixed
     */
    public function update(User $user, address $address)
    {
        return $user->hasAccess("admin.user.addresses.update");
    }

    /**
     * Determine whether the user can delete the address.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\address  $address
     * @return mixed
     */
    public function delete(User $user, address $address)
    {
        return $user->hasAccess("admin.user.addresses.destroy");
    }
}
