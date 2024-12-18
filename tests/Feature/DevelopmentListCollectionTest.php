<?php 
declare(strict_types=1);

namespace Tests\Unit\Http\Resources;

use Tests\TestCase;
use App\Http\Resources\DevelopmentListCollection;
use Illuminate\Support\Collection;

class DevelopmentListCollectionTest extends TestCase
{
    public function testDevelopmentListCollectionFiltersOutNotSetdevelopments(): void
    {
        $developments = new Collection([
            'Spring',
            'Laravel',
            'Angular',
            'React',
        ]);

        $resource = new DevelopmentListCollection($developments);

        $result = $resource->resolve();

        $this->assertNotContains(['development' => 'Not Set'], $result['developments']);
    }

    public function testDevelopmentCollectionTransformsdevelopmentsCorrectly(): void
    {
        $developments = new Collection([
            'Spring',
            'Laravel',
            'Angular',
            'React',
        ]);

        $resource = new DevelopmentListCollection($developments);

        $result = $resource->resolve();

        $this->assertEquals([
            'developments' => [
                ['development' => 'Spring'],
                ['development' => 'Laravel'],
                ['development' => 'Angular'],
                ['development' => 'React'],
            ]
        ], $result);
    }

    public function testDevelopmentListCollectionReturnsEmptyArrayWhenNodevelopments(): void
    {
        $developments = new Collection([]);

        $resource = new DevelopmentListCollection($developments);

        $result = $resource->resolve();

        $this->assertEquals(['developments' => []], $result);
    }
}