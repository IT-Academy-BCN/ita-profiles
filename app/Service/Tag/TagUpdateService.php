<?php

declare(strict_types=1);

namespace App\Service\Tag;

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
        $tag = $this->getTagOrThrowException($tagId);
        $tag->update($data);
        return new TagResource($tag);
    }
    public function getTagOrThrowException($tagId): Tag
    {
        $tag = Tag::find($tagId);
        if (!$tag) {
            throw new TagNotFoundException($tagId);
        }
        return $tag;
    }
}
