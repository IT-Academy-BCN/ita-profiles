<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'status' => Str::ucfirst($this->status),
            'resume' => new ResumeResource($this->resume),
        ];
    }
}
