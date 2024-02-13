<?php

declare(strict_types=1);
namespace App\Service\Resume;
use App\Models\Resume;
use App\Http\Resources\ResumeShowResource;

class ResumeShowService{

    public function execute(
        string $resumeId,
        ?string $subtitle = null,
        ?string $linkedinUrl = null,
        ?string $githubUrl = null,
        ?string $specialization = null
    ):Resume{
        $resume = Resume::find($resumeId);
        return response()->json(
            [
                'resume' => ResumeShowResource::make($resume)],
            200
        );
    }

}