<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Tag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Tag\TagStoreService;
use App\Http\Controllers\api\Tag\TagStoreController;
use App\Models\Tag;

class TagStoreControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected TagStoreService $tagStoreService;

    public function testStoreTag()
    {
        $tagName = 'New Tag';

        $response = $this->postJson(route('tag.store'), [
            'tag_name' => $tagName,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'tag' => [
                'id',
                'tag_name',
            ],
        ]);

        $this->assertDatabaseHas('tags', [
            'tag_name' => $tagName,
        ]);
        $this->assertEquals($response->json('tag')['tag_name'], $tagName);
    }

    public function testStoreFailsWhenTagNameIsMissing()
    {
        $response = $this->postjson(route('tag.store'), []);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'tag_name',
            ],
        ]);

        $response->assertJsonFragment([
            'tag_name' => ['El camp tag name és obligatori.'],
        ]);

        $response->assertJsonValidationErrors(['tag_name']);

    }
    public function testStoreFailsWhenTagNameIsInteger()
    {
        $response = $this->postJson(route('tag.store'), [
            'tag_name' => 12345,
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'tag_name',
            ],
        ]);

        $response->assertJsonFragment([
            'tag_name' => ['El camp tag name ha de ser una cadena.'],
        ]);

        $response->assertJsonValidationErrors(['tag_name']);
    }
    public function testReturnsUnprocessableContentWhenUsingATooLongTagName(): void
    {
        $response = $this->postJson(route('tag.store'), [
            'tag_name' => str_repeat('a', 76),
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'Error de validació.',
            'errors' => [
                'tag_name' => [
                    'Tag name no pot ser més gran que 75 caràcters.',
                ],
            ],
        ]);

        $response->assertJsonValidationErrors(['tag_name']);

    }
    public function testFailsWithDuplicateName(): void
    {
        $existingTag = Tag::factory(['tag_name' => 'Existing Tag'])->create();

        $response = $this->postJson(route('tag.store'), [
            'tag_name' => $existingTag->tag_name,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['tag_name']);
    }
    public function testCanInstantiate(): void
    {
        $tagStoreService = $this->createMock(TagStoreService::class);

        $controller = new TagStoreController($tagStoreService);

        $this->assertInstanceOf(TagStoreController::class, $controller);
    }
}
