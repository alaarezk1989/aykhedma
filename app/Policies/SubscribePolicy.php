<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Subscribe;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscribePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the subscribe index.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        // check if the user is not admin return false before access any rolls
        if (!$user->isTypeOf(UserTypes::ADMIN) && !$user->isTypeOf(UserTypes::VENDOR)) {
            return false;
        }
    }

    /**
     * Determine whether the user can view the subscribe index.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAccess("admin.subscribes.index");
    }

    /**
     * Determine whether the user can create subscribes.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess("admin.subscribes.create");
    }

    /**
     * Determine whether the user can update the subscribe.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscribe  $subscribe
     * @return mixed
     */
    public function update(User $user, Subscribe $subscribe)
    {
        return $user->hasAccess("admin.subscribes.update", $subscribe);
    }

    /**
     * Determine whether the user can delete the subscribe.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscribe  $subscribe
     * @return mixed
     */
    public function delete(User $user, Subscribe $subscribe)
    {
        return $user->hasAccess("admin.subscribes.destroy", $subscribe);
    }
}
