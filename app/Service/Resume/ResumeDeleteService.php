<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Exceptions\UserNotAuthenticatedException;
use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ResumeDeleteService
{
    public function execute(string $resumeId)
    {
        $resume = Resume::find($resumeId);
        $resumeId = Auth::user()->student->resume->id;
        if (! $resume) {
            throw new ModelNotFoundException(
                __('Currículum no trobat'), 404);
        }
        if ($resumeId != $resume->id) {
            throw new UserNotAuthenticatedException();
        }

        $resume->delete();

    }
}
