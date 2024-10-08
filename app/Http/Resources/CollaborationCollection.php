<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CollaborationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'collaborations' => $this->collection->map(function ($collaboration) {
                return [
                    'uuid' => $collaboration->id,
                    'collaboration_name' => $collaboration->collaboration_name,
                    'collaboration_description' => $collaboration->collaboration_description,
                    'collaboration_quantity' => $collaboration->collaboration_quantity,
                ];
            })->toArray()
        ];
    }
}
