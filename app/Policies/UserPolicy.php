<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function manage(User $user)
    {
        return $user->role === 'manager';
    }

    public function view(User $user, User $model)
    {
        return true; // anyone authenticated can view
    }
}
