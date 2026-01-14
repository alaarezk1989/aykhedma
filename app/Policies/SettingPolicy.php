<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the setting index.
     *
     * @param User $user
     * @return bool|null
     */
    public function before(User $user)
    {
        // check if the user is not admin return false before access any rolls
        if (!$user->isTypeOf(UserTypes::ADMIN)) {
            return false;
        }
        return null;
    }

    /**
     * Determine whether the user can view any settings.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasAccess("admin.settings.index");
    }

    /**
     * Determine whether the user can update the unit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity  $activity
     * @return mixed
     */
    public function update(User $user, Setting $setting)
    {
        return $user->hasAccess("admin.settings.update");
    }
}
