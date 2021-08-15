<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Discount;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Discount index.
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
     * Determine whether the user can view the Discount index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.discounts.index");
    }

    /**
     * Determine whether the user can create discounts.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.discounts.create");
    }

    /**
     * Determine whether the user can update the Discount.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Discount $discount
     * @return mixed
     */
    public function update(User $user, Discount $discount)
    {
        return $user->hasAccess("admin.discounts.update");
    }

    /**
     * Determine whether the user can delete the Discount.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Discount $discount
     * @return mixed
     */
    public function delete(User $user, Discount $discount)
    {
        return $user->hasAccess("admin.discounts.destroy");
    }
}
