<?php

namespace Tests\Feature\Controller\Tag;

use App\Http\Controllers\api\Tag\TagCreateController;
use App\Models\Tag;
use App\Service\Tag\TagCreateService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TagCreateControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreTag()
    {
        $tagName = 'New Tag';

        $response = $this->postJson(route('tag.create'), [
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
        $response = $this->postjson(route('tag.create'), []);

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
    }
    public function testStoreFailsWhenTagNameIsInteger()
    {
        $response = $this->postJson(route('tag.create'), [
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
    }
    public function testReturnsUnprocessableContentWhenUsingATooLongTagName(): void
    {
        $response = $this->postJson(route('tag.create'), [
            'tag_name' => str_repeat('a', 76),
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'Tag name no pot ser més gran que 75 caràcters.',
            'errors' => [
                'tag_name' => [
                    'Tag name no pot ser més gran que 75 caràcters.',
                ],
            ],
        ]);
    }
    public function testCreateTagFailsWithDuplicateName(): void
    {
        $existingTag = Tag::factory(['tag_name' => 'Existing Tag'])->create();

        $response = $this->postJson(route('tag.create'), [
            'tag_name' => $existingTag->tag_name,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['tag_name']);
    }
    public function testTagCreateControllerCanBeInstantiated(): void
    {
        $tagCreateService = $this->createMock(TagCreateService::class);
        $controller = new TagCreateController($tagCreateService);
        $this->assertInstanceOf(TagCreateController::class, $controller);
    }
}
