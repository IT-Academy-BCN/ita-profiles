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
        return [
            'name' => Str::ucfirst($this->user->name),
            'surname' => Str::ucfirst($this->user->surname),
            'subtitle' =>  Str::ucfirst($this->subtitle),
            'about ' => Str::ucfirst($this->about),
            'cv' => $this->cv,
            'bootcamp' => $this->bootcamp,
            'endDate' => $this->endDate,
            'linkedin' => $this->linkedin,
            'github ' => $this->github,
        ];
    }

}
