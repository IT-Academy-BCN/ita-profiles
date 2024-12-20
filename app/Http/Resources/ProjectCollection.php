<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'projects' => $this->collection->map(function ($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'company_name' => $project->company_name,
                    'github_url' => $project->github_url,
                    'project_url' => $project->project_url,
                    'tags' => $project->tags->map(function ($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->name,
                        ];
                    }),
                ];
            }),
        ];
    }
}
