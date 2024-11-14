<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Tag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\api\Tag\TagStoreController;
use App\Models\Tag;

class TagStoreControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreTag()
    {
        $tagName = 'New Tag';

        $response = $this->postJson(route('tag.store'), [
            'name' => $tagName,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'message',
            'tag' => [
                'id',
                'name',
            ],
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => $tagName,
        ]);

        $this->assertEquals($tagName, $response->json('tag')['name']);
    }

    public function testStoreFailsWhenTagNameIsMissing()
    {
        $response = $this->postJson(route('tag.store'), []);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);

        $response->assertJsonValidationErrors(['name']);

    }
    public function testStoreFailsWhenTagNameIsInteger()
    {
        $response = $this->postJson(route('tag.store'), [
            'name' => 12345,
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);

        $response->assertJsonValidationErrors(['name']);
    }
    public function testReturnsUnprocessableContentWhenUsingATooLongTagName(): void
    {
        $response = $this->postJson(route('tag.store'), [
            'name' => str_repeat('a', 76),
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);

        $response->assertJsonValidationErrors(['name']);

    }
    public function testFailsWithDuplicateName(): void
    {
        $existingTag = Tag::factory(['name' => 'Existing Tag'])->create();

        $response = $this->postJson(route('tag.store'), [
            'name' => $existingTag->name,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['name']);
    }
    public function testCanInstantiate(): void
    {
        $controller = new TagStoreController();
    
        $this->assertInstanceOf(TagStoreController::class, $controller);
    }
}
