<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
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
        return $user->hasAccess("admin.units.index");
    }

    /**
     * Determine whether the user can create units.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.units.create");
    }

    /**
     * Determine whether the user can update the unit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return mixed
     */
    public function update(User $user, Unit $unit)
    {
        return $user->hasAccess("admin.units.update");
    }

    /**
     * Determine whether the user can delete the unit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return mixed
     */
    public function delete(User $user, Unit $unit)
    {
        return $user->hasAccess("admin.units.destroy");
    }
}
