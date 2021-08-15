<?php

namespace App\Policies;

use App\Models\User;
use App\Constants\UserTypes;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if (!$user->isTypeOf(UserTypes::ADMIN)) {
            return false;
        }
    }

    public function quantityAnalysis(User $user)
    {
        return $user->hasAccess("admin.reports.quantity");
    }
}
