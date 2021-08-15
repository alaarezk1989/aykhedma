<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Shipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipmentPolicy
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
        return $user->hasAccess("admin.shipments.index");
    }

    public function create(User $user)
    {
        return $user->hasAccess("admin.shipments.create");
    }

  
    public function update(User $user, Shipment $shipment)
    {
        return $user->hasAccess("admin.shipments.update");
    }


    public function delete(User $user, Shipment $shipment)
    {
        return $user->hasAccess("admin.shipments.destroy");
    }
}
