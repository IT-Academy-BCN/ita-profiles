<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\ResumeResource;
use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'fullname' => Str::ucfirst($this->name) . " " . Str::ucfirst($this->surname),
            'photo' => $this->photo,
            'status' => $this->status,
            'tags' => TagResource::collection($this->tags),
            'resume' => new ResumeResource($this->resume),
        ];
    }
}
