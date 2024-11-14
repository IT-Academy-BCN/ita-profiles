<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Tag;

use Tests\TestCase;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\api\Tag\TagUpdateController;

class TagUpdateControllerTest extends TestCase
{
    use DatabaseTransactions;
   
    private $tag;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tag = Tag::first() ?? Tag::factory()->create(['name' => 'Initial Tag Name']);
    }

    public function testUpdateTagSuccessfully()
    {
        $updatedTagName = 'Updated Tag Name';

        $response = $this->putJson(route('tag.update', ['tag' => $this->tag->id]), [
            'name' => $updatedTagName,
        ]);
        $response->assertStatus(200);

        $this->tag->refresh();

        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id,
            'name' => $updatedTagName,
        ]);
        $this->assertEquals($updatedTagName, $this->tag->name);
    }

    public function testAllowsToUpdateATagByUsingItsSameName(): void
    {
        $updatedTagName = $this->tag->name;

        $response = $this->putJson(route('tag.update', ['tag' => $this->tag->id]), [
            'name' => $updatedTagName,
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id,
            'name' => $updatedTagName,
        ]);
        $this->assertEquals($updatedTagName, $this->tag->name);
    }

    public function testUpdateTagFailsForNonExistentTag(): void
    {
        $nonExistentTagId = 0;

        $response = $this->putJson(route('tag.update', ['tag' => $nonExistentTagId]), [
            'name' => 'New Name',
        ]);

        $response->assertStatus(404);
    }

    public function testReturnsUnprocessableContentWhenMissingTagName(): void
    {
        $response = $this->putJson(route('tag.update', ['tag' => $this->tag->id]), [
            'name' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testUpdateTagFailsWhenTagNameIsInteger(): void
    {
        $response = $this->putJson(route('tag.update', ['tag' => $this->tag->id]), [
            'name' => 12345,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testReturnsUnprocessableContentWhenUsingATooLongTagName(): void
    {
        $response = $this->putJson(route('tag.update', ['tag' => $this->tag->id]), [
            'name' => str_repeat('a', 76),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testReturnsUnprocessableContentWithDuplicateName(): void
    {
        $otherTag = Tag::find($this->tag->id + 1) ?? Tag::factory()->create(['name' => 'Other Tag Name']);

        $response = $this->putJson(route('tag.update', ['tag' => $otherTag->id]), [
            'name' => $this->tag->name,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testTagUpdateControllerCanBeInstantiated(): void
    {
        $controller = new TagUpdateController();
        $this->assertInstanceOf(TagUpdateController::class, $controller);
    }
}
