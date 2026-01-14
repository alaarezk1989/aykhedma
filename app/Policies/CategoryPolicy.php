<?php

namespace App\Policies;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the unit index.
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
     * Determine whether the user can view any categories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasAccess("admin.categories.index");
    }

    public function create(User $user)
    {
        return $user->hasAccess("admin.categories.create");
    }

    public function view(User $user, Category $category)
    { 
        return $user->hasAccess("admin.categories.show");
    }

    public function update(User $user, Category $category)
    {
        return $user->hasAccess("admin.categories.update");
    }
 
    public function delete(User $user, Category $category)
    {
        return $user->hasAccess("admin.categories.destroy");
    }

}
