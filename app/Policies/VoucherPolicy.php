<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoucherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the voucher index.
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
     * Determine whether the user can view the voucher index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.vouchers.index");
    }

    /**
     * Determine whether the user can create vouchers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.vouchers.create");
    }

    /**
     * Determine whether the user can update the voucher.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Voucher  $voucher
     * @return mixed
     */
    public function update(User $user, Voucher $voucher)
    {
        return $user->hasAccess("admin.vouchers.update");
    }

    /**
     * Determine whether the user can delete the voucher.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Voucher  $voucher
     * @return mixed
     */
    public function delete(User $user, Voucher $voucher)
    {
        return $user->hasAccess("admin.vouchers.destroy");
    }

    public function list(User $user)
    {
        return $user->hasAccess("admin.vouchers.list");
    }
}
