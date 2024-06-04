<?php

declare(strict_types=1);

namespace App\Service\Tag;

use App\Http\Resources\Tag\TagResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Tag;

class TagDetailService
{
    public function execute(int $tagId): array
    {
        return $this->getTagDetailsById($tagId);
    }

    public function getTagDetailsById(int $tagId): array
    {
        $tag = $this->getTag($tagId);
        return [
            'id' => $tag->id,
            'tag_name' => $tag->tag_name,
            'created_at' => $tag->created_at,
            'updated_at' => $tag->updated_at,
        ];
    }

    private function getTag(int $tagId): TagResource
    {
        $tag = Tag::find($tagId);

        if (!$tag) {
            throw new ModelNotFoundException("Tag not found with id {$tagId}");
        }

        return new TagResource($tag);
    }
}
