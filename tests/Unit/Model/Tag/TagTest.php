<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TagTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $this->tag = new Tag(['id' => 1, 'name' => 'name']);
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(Tag::class, $this->tag);
    }

    public function testCanTranslateToArray(): void
    {
        $result = $this->tag->toArray();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
    }
}
