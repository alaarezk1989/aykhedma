<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderProduct;
use App\Constants\UserTypes ;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderProductPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if (!$user->isTypeOf(UserTypes::ADMIN) && !$user->isTypeOf(UserTypes::VENDOR)) {
            return false;
        }
    }

    public function index(User $user)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.order.products.index");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.order.products.index");
        }
    }

    public function create(User $user)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.order.products.add");
        }

        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.order.products.create");
        }
    }

    public function update(User $user, OrderProduct $orderProduct)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.order.products.update");
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.order.products.update");
        }
    }

    public function delete(User $user, OrderProduct $orderProduct)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess('admin.order.products.destroy');
        }
        if ($user->type == UserTypes::VENDOR) {
            return $user->hasAccess("vendor.order.products.destroy");
        }
    }

}
