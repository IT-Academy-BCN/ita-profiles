<?php

declare(strict_types=1);

namespace App\Service\Tag;

use App\Models\Tag;
use App\Http\Resources\TagResource;
use Exception;

class TagStoreService
{
    public function execute(array $data): TagResource
    {
        try {
            $tag = Tag::create($data);
            return new TagResource($tag);
        } catch (Exception $e) {
            throw new Exception('Error en la creació de l\'etiqueta.', 500);
        }
    }
}
