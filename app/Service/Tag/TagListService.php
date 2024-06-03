<?php

declare(strict_types=1);

namespace App\Service\Tag;

use App\Models\Tag;

class TagListService
{
    public function execute(): array
    {
        return $this->getTagList();
    }

    public function getTagList(): array
    {
        $tags = Tag::get();

        return $this->mapTagDetails($tags);

    }

    private function mapTagDetails(object $tags): array
    {
        return $tags->map(function ($tag) {
            return [
                'id' => $tag->id,
                'tag_name' => $tag->tag_name,
            ];
        })->toArray();
    }
}