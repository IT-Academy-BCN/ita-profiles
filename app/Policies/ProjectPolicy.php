<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Project $project): Response
    {
        if ($user->student->resume->projects->contains($project)) {
            return Response::allow();
        }
        return Response::deny('This action is unauthorized.', 403);
    }
}
