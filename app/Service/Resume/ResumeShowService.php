<?php

declare(strict_types=1);
namespace App\Service\Resume;
use App\Models\Resume;
use App\Http\Resources\ResumeShowResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Exceptions\UserNotAuthenticatedException;
use Illuminate\Support\Facades\Auth;

class ResumeShowService{

    public function execute(string $resumeId): ResumeShowResource
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            throw new UserNotAuthenticatedException();
        }

        $resume = Resume::findOrFail($resumeId);

        return ResumeShowResource::make($resume);
    }

}