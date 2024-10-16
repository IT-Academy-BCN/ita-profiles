<?php

declare(strict_types=1);

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
                    'name' => $collaboration->name,
                    'description' => $collaboration->description,
                    'quantity' => $collaboration->quantity,
                ];
            })->toArray()
        ];
    }
}
