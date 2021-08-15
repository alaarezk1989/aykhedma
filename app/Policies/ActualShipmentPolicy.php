<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\ActualShipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActualShipmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the actual_shipment index.
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
     * Determine whether the user can view the actual_shipment index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.actual_shipments.index");
    }

    /**
     * Determine whether the user can create actual_shipments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.actual_shipments.create");
    }

    /**
     * Determine whether the user can update the actual_shipment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ActualShipment  $actualShipment
     * @return mixed
     */
    public function update(User $user, ActualShipment $actualShipment)
    {
        return $user->hasAccess("admin.actual_shipments.update", $actualShipment);

    }

    /**
     * Determine whether the user can delete the actual_shipment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ActualShipment  $actualShipment
     * @return mixed
     */
    public function delete(User $user, ActualShipment $actualShipment)
    {
        return $user->hasAccess("admin.actual_shipments.destroy", $actualShipment);
    }
}
