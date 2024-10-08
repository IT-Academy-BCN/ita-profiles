<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'modality' => $this->modality,
            'subtitle' => $this->subtitle,
            'social_media' => [
                'github' => $this->github_url,
                'linkedin' => $this->linkedin_url,
            ],
            'about' => $this->about
        ];
    }
}
