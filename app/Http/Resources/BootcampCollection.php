<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BootcampCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'bootcamps' => $this->collection->map(function ($bootcamp) {
                return [
                    'id' => $bootcamp->id,
                    'name' => $bootcamp->name,
                    'end_date' => $bootcamp->pivot->end_date,
                ];
            })
        ];
    }
}
