<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Coupon index.
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
     * Determine whether the user can view the Coupon index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.coupons.index");
    }

    /**
     * Determine whether the user can create coupons.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.coupons.create");
    }

    /**
     * Determine whether the user can update the Coupon.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Coupon $coupon
     * @return mixed
     */
    public function update(User $user, Coupon $coupon)
    {
        return $user->hasAccess("admin.coupons.update");
    }

    /**
     * Determine whether the user can delete the Coupon.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Coupon $coupon
     * @return mixed
     */
    public function delete(User $user, Coupon $coupon)
    {
        return $user->hasAccess("admin.coupons.destroy");
    }
}
