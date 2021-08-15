<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the unit index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.orders.index");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.orders.index");
        }
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.orders.create");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.orders.create");
        }
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.orders.update");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.orders.update");
        }
    }

    public function view(User $user, Order $order)
    {
        return $user->hasAccess("admin.orders.show");
    }

    public function delete(User $user, Order $order)
    {
        return $user->hasAccess("admin.orders.destroy");
    }
}
