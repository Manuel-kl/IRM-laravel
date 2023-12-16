<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view existing admins. (R)
     */
    public function viewAdmins(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can manage other admins. (CRUD admins)
     */
    public function managesAdmins(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can manage their own account. (CRUD self)
     */
    public function managesTheirAccount($user, $loggedInUser): bool
    {
        return $user->id === $loggedInUser->id;
    }
}
