<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Resources;

use Tests\TestCase;
use App\Http\Resources\SpecializationListCollection;
use Illuminate\Support\Collection;

class SpecializationListCollectionTest extends TestCase
{
    public function testSpecializationListCollectionFiltersOutNotSetSpecializations(): void
    {
        $specializations = new Collection([
            'Frontend',
            'Backend',
            'Not Set',
            'Fullstack',
            'Data Science',
        ]);

        $resource = new SpecializationListCollection($specializations);

        $result = $resource->resolve();

        $this->assertNotContains(['specialization' => 'Not Set'], $result['specializations']);
    }

    public function testSpecializationListCollectionTransformsSpecializationsCorrectly(): void
    {
        $specializations = new Collection([
            'Frontend',
            'Backend',
            'Fullstack',
            'Data Science',
        ]);

        $resource = new SpecializationListCollection($specializations);

        $result = $resource->resolve();

        $this->assertEquals([
            'specializations' => [
                ['specialization' => 'Frontend'],
                ['specialization' => 'Backend'],
                ['specialization' => 'Fullstack'],
                ['specialization' => 'Data Science'],
            ]
        ], $result);
    }

    public function testSpecializationListCollectionReturnsEmptyArrayWhenNoSpecializations(): void
    {
        $specializations = new Collection([]);

        $resource = new SpecializationListCollection($specializations);

        $result = $resource->resolve();

        $this->assertEquals(['specializations' => []], $result);
    }
}