<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Branch;
use App\Models\BranchProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the branchProduct index.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        // check if the user is not admin and not vendor return false before access any rolls
        if (!$user->isTypeOf(UserTypes::ADMIN) && !$user->isTypeOf(UserTypes::VENDOR)) {
            return false;
        }
    }

    public function index(User $user, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branch.products.index", $branch);
        }

        if ($user->type == UserTypes::VENDOR && $user->vendor_id == $branch->vendor_id) {
            return $user->hasAccess("vendor.branch.products.index");
        }
    }

    /**
     * Determine whether the user can create branchProducts.
     *
     * @param User $user
     * @param Branch $branch
     * @return mixed
     */
    public function create(User $user, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branch.products.create", $branch);
        }

        if ($user->type == UserTypes::VENDOR && $user->vendor_id == $branch->vendor_id) {
            return $user->hasAccess("vendor.branch.products.create");
        }
    }

    /**
     * Determine whether the user can update the branchProduct.
     * @param User $user
     * @param BranchProduct $branchProduct
     * @return bool
     */
    public function update(User $user, BranchProduct $branchProduct, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branch.products.update", $branch);
        }

        if ($user->type == UserTypes::VENDOR && $user->vendor_id == $branch->vendor_id) {
            return $user->hasAccess("vendor.branch.products.update");
        }
    }

    /**
     * Determine whether the user can delete the branchProduct.
     *
     * @param User $user
     * @param  \App\Models\BranchProduct  $branchProduct
     * @return mixed
     */
    public function delete(User $user, BranchProduct $branchProduct, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branch.products.destroy", $branch);
        }

        if ($user->type == UserTypes::VENDOR && $user->vendor_id == $branch->vendor_id) {
            return $user->hasAccess("vendor.branch.products.destroy");
        }
    }
}
