<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class StudentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /* return [
            'name' => Str::ucfirst($this->user->name),
            'surname' => Str::ucfirst($this->user->surname),
            'subtitle' => Str::ucfirst($this->subtitle),
            'about ' => Str::ucfirst($this->about),
            'cv' => $this->cv,
            'bootcamp' => $this->bootcamp,
            'end_date' => $this->end_date,
            'linkedin' => $this->linkedin,
            'github ' => $this->github,
        ]; */
        return [
            'id' => $this->id,
            'name' => Str::ucfirst($this->user->name),
            'surname' => Str::ucfirst($this->user->surname),
            'subtitle' => Str::ucfirst($this->subtitle),
            'tags' => $this->tags->pluck('tag_name'),
            'photo_url' => url('img/stud_' . rand(1, 3) . '.png'),
        ];
        
    }
}
