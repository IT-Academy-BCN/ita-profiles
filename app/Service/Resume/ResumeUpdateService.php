<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Exceptions\UserNotAuthenticatedException;
use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class ResumeUpdateService
{
    public function execute(
        string $resumeId,
        ?string $subtitle = null,
        ?string $linkedinUrl = null,
        ?string $githubUrl = null,
        ?string $specialization = null
    ): void{

        $transaction= DB::transaction(function () use ($resumeId, $subtitle, $linkedinUrl, $githubUrl, $specialization) {
        $resume = Resume::find($resumeId);
     
        $resumeId = Auth::user()->student->resume->id;
        if (! $resume) {
            throw new ModelNotFoundException(
                __('Currículum no trobat'), 404);
        }
        if ($resumeId != $resume->id) {
            throw new UserNotAuthenticatedException();
        }
        if (empty($subtitle)  && empty($linkedinUrl)  && empty($githubUrl) && empty($specialization)) {
            throw new \Exception(__('No s\'han proporcionat dades per actualitzar'), 400);
        }
        if ($subtitle !== null) {
            $resume->subtitle = $subtitle;
        }

        if ($linkedinUrl !== null) {
            $resume->linkedin_url = $linkedinUrl;
        }

        if ($githubUrl !== null) {
            $resume->github_url = $githubUrl;
        }

        if ($specialization !== null) {
            $resume->specialization = $specialization;
        }

        $resume->save();

        return $resume;
    });

    if(!$transaction){
        throw new \Exception(__('La transacció de base de dades ha fallat.'),500);
    }

    }

    

}
