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
            'name' => $tagName,
        ]);

        $response->assertStatus(201);

        /*$response->assertJsonStructure([
            'tag' => [
                'id',
                'name',
            ],
        ]);*/

        /*$this->assertDatabaseHas('tags', [
            'name' => $tagName,
        ]);*/
        //$this->assertEquals($response->json('tag')['name'], $tagName);
    }

    public function testStoreFailsWhenTagNameIsMissing()
    {
        $response = $this->postjson(route('tag.store'), []);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);

        $response->assertJsonFragment([
            'name' => ['El camp nom és obligatori.'],
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

        $response->assertJsonFragment([
            'name' => ['El camp nom ha de ser una cadena.'],
        ]);

        $response->assertJsonValidationErrors(['name']);
    }
    public function testReturnsUnprocessableContentWhenUsingATooLongTagName(): void
    {
        $response = $this->postJson(route('tag.store'), [
            'name' => str_repeat('a', 76),
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'Error de validació.',
            'errors' => [
                'name' => [
                    'Nom no pot ser més gran que 75 caràcters.',
                ],
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
        $tagStoreService = $this->createMock(TagStoreService::class);

        $controller = new TagStoreController($tagStoreService);

        $this->assertInstanceOf(TagStoreController::class, $controller);
    }
}
