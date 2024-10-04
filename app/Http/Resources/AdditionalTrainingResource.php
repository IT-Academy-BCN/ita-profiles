<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdditionalTrainingResource extends JsonResource
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
            'course_name' => $this->course_name,
            'study_center' => $this->study_center,
            'course_beginning_year' => $this->course_beginning_year,
            'course_ending_year' => $this->course_ending_year,
            'duration_hrs' => $this->duration_hrs
        ];
    }
}
