<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the banner index.
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
     * Determine whether the user can view the banner index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.banners.index");
    }

    /**
     * Determine whether the user can create banners.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.banners.create");
    }

    /**
     * Determine whether the user can update the Banner.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Banner  $banner
     * @return mixed
     */
    public function update(User $user, Banner $banner)
    {
        return $user->hasAccess("admin.banners.update");
    }

    /**
     * Determine whether the user can delete the Banner.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Banner  $banner
     * @return mixed
     */
    public function delete(User $user, Banner $banner)
    {
        return $user->hasAccess("admin.banners.destroy");
    }
}
