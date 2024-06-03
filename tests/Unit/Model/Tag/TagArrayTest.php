<?php

namespace Tests\Unit\Model\Tag;

use App\Models\Tag;
use App\ValueObjects\Tag\TagArray;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use stdClass;
use Tests\TestCase;

class TagArrayTest extends TestCase
{
    use DatabaseTransactions;

    private TagArray $tagArray;

    public function setUp(): void
    {
        parent::setUp();

        Tag::query()->delete();
        $this->tagArray = new TagArray();
    }

    public function testCanInstantiate() {
        $this->assertInstanceOf(TagArray::class, $this->tagArray);
    }

    public function testCanTranslateFromACollection(): void
    {
        $tags = Tag::factory()->count(26)->create();

        $result = $this->tagArray->fromCollection($tags);

        $this->assertIsArray($result);
    }

    public function testCanThrowExceptionWhenCollectionDoesNotContainTags(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $fakeModel = new stdClass();
        $fakeModel->patata = true;

        $patataCollection = new Collection();
        $patataCollection->add($fakeModel);

        $this->tagArray->fromCollection($patataCollection);
    }
}
