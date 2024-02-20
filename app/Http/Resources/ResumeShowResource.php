<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subtitle' => $this->subtitle,
            'linkedin_url' => $this->linkedin_url,
            'github_url' => $this->github_url,
            'tags_ids' => $this->tags_ids,
            'specialization' => $this->specialization,

        ];
    }
}
