<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Segmentation;
use Illuminate\Auth\Access\HandlesAuthorization;

class SegmentationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the segmentation index.
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
     * Determine whether the user can view the segmentation index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.segmentation.index");
    }

    /**
     * Determine whether the user can create segmentations.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.segmentation.create");
    }

    /**
     * Determine whether the user can update the segmentation.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Segmentation  $segmentation
     * @return mixed
     */
    public function update(User $user, Segmentation $segmentation)
    {
        return $user->hasAccess("admin.segmentation.update");
    }

    /**
     * Determine whether the user can delete the segmentation.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Segmentation  $segmentation
     * @return mixed
     */
    public function delete(User $user, Segmentation $segmentation)
    {
        return $user->hasAccess("admin.segmentation.destroy");
    }
}
