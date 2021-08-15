<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
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
        return $user->hasAccess("admin.vehicles.index");
    }

    /**
     * Determine whether the user can create vehicles.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.vehicles.create");
    }

    /**
     * Determine whether the user can update the vehicle.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Vehicle $vehicle
     * @return mixed
     */
    public function update(User $user, Vehicle $vehicle)
    {
        return $user->hasAccess("admin.vehicles.update");
    }

    /**
     * Determine whether the user can delete the vehicle.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Vehicle $vehicle
     * @return mixed
     */
    public function delete(User $user, Vehicle $vehicle)
    {
        return $user->hasAccess("admin.vehicles.destroy");
    }
}
