<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\TagNotFoundException;
use App\Models\Tag;
use App\Http\Resources\TagResource;

class TagUpdateService
{
    public function execute(array $data, int $tagId): TagResource
    {
        return $this->updateTag($data, $tagId);
    }

    public function updateTag(array $data, int $tagId): TagResource
    {
        $tag = Tag::find($tagId);
        if (!$tag) {
            throw new TagNotFoundException($tagId);
        }
        $tag->update($data);

        return new TagResource($tag);
    }
}
