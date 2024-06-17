<?php

declare(strict_types=1);

namespace App\Service\Tag;

use App\Models\Tag;
use App\ValueObjects\Tag\TagArray;

class TagListService
{
    private TagArray $tagArray;

    public function __construct(TagArray $tagArray)
    {
        $this->tagArray = $tagArray;
    }

    public function execute(): array
    {
        return $this->tagArray->fromCollection(Tag::get());
    }
}
