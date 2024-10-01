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
                    'github_url' => $project->github_url,
                    'project_url' => $project->project_url,
                    'company_name' => $project->company_name,
                    'tags' => $project->tags->map(function ($tag) {
                        return [
                            'id' => $tag->id,
                            // Right now the correct name of the property is tag_name, but it should be renamed to name.
                            'name' => $tag->name,
                        ];
                    }),
                ];
            }),
        ];
    }
}
