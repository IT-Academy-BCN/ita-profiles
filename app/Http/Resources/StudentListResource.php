<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user->name,
            'surname' => $this->user->surname,
            'subtitle' => $this->subtitle,
            'about ' => $this->about,
            'cv' => $this->cv,
            'bootcamp' => $this->bootcamp,
            'endDate' => $this->endDate,
            'linkedin' => $this->linkedin,
            'github ' => $this->github,
        ];
    }
}
