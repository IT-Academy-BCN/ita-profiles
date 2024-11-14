<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can access the given resource (can be changed to isOwner, maybe is more clear). 
     */
    public function canAccessResource(User $authenticatedUser, User $userProfile): Response
    {
        if ($authenticatedUser->id === $userProfile->id) {
            return Response::allow();
        } else {
            return Response::deny('No tens els permisos per accedir a aquest recurs.');
        }
    }
}
