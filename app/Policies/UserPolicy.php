<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the given profile
     *
     * @param User $user
     * @param User $signedInUser
     */
    public function update(User $user, User $signedInUser)
    {
        return $user->id === $signedInUser->id;
    }
}
