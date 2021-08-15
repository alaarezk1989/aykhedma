<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Branch;
use App\Models\BranchZone;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchZonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the branchZone index.
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
            return $user->hasAccess("admin.branch.zones", $branch);
        }

        if ($user->type == UserTypes::VENDOR && $user->vendor_id == $branch->vendor_id) {
            return $user->hasAccess("vendor.branch.zones");
        }
    }

    /**
     * Determine whether the user can create branchZones.
     *
     * @param User $user
     * @param Branch $branch
     * @return mixed
     */
    public function create(User $user, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branch.zones.create", $branch);
        }

        if ($user->type == UserTypes::VENDOR && $user->vendor_id == $branch->vendor_id) {
            return $user->hasAccess("vendor.branch.zones.create");
        }
    }

    /**
     * Determine whether the user can update the branchZone.
     * @param User $user
     * @param BranchZone $branchZone
     * @return bool
     */
    public function update(User $user, BranchZone $branchZone, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branch.zones.update", $branch);
        }

        if ($user->type == UserTypes::VENDOR && $user->vendor_id == $branch->vendor_id) {
            return $user->hasAccess("vendor.branch.zones.update");
        }
    }

    /**
     * Determine whether the user can delete the branchZone.
     *
     * @param User $user
     * @param  \App\Models\BranchZone  $branchZone
     * @return mixed
     */
    public function delete(User $user, BranchZone $branchZone, Branch $branch)
    {
        if ($user->type == UserTypes::ADMIN) {
            return $user->hasAccess("admin.branch.zones.destroy", $branch);
        }

        if ($user->type == UserTypes::VENDOR && $user->vendor_id == $branch->vendor_id) {
            return $user->hasAccess("vendor.branch.zones.destroy");
        }
    }
}
