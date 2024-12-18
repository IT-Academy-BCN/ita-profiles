<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DevelopmentListCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        $filteredDevelopments = $this->collection->filter(function ($development) {
            return $development !== 'Not Set';  
        });

        return [
            'development' => $filteredDevelopments->values()->toArray()
        ];
    }
}
