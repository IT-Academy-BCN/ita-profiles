<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecializationListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $filteredSpecializations = $this->collection->filter(function ($specialization) {
            return $specialization !== 'Not Set';  
        });

        return [
            'specializations' => $filteredSpecializations->map(function ($specialization) {
                return [
                    'specialization' => $specialization,  
                ];
            })->values()->toArray()
        ];
    }
}