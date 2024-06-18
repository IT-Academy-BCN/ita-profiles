<?php

declare(strict_types=1);

namespace App\ValueObjects\Tag;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class TagArray
{
    public function fromCollection(Collection $tagCollection): array
    {
        $return = [];

        /** @var Tag $tagModel */
        foreach ($tagCollection as $tagModel) {
            if($tagModel instanceof Tag) {
                $return[] = $tagModel->toArray();
            } else {
                throw new InvalidArgumentException('Invalid Tag Model');
            }
        }

        return $return;
    }
}
