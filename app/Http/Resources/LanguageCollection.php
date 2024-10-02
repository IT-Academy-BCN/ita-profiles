<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LanguageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'languages' => $this->collection->map(function ($language): array {
                return [
                    'id' => $language->id,
                    'name' => $language->language_name,
                    'level' => $language->language_level
                ];
            })
        ];
    }
}
