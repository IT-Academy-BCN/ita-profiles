<?php

declare(strict_types=1);

namespace App\Service\Tag;

use App\Models\Tag;
use App\Http\Resources\Tag\TagResource;

class TagStoreService
{
    public function execute(array $data): TagResource
    {
        $tag = Tag::create($data);
        return new TagResource($tag);
    }
}
