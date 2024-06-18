<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Tag;

use Tests\TestCase;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\api\Tag\TagUpdateController;
use App\Service\Tag\TagUpdateService;

class TagUpdateControllerTest extends TestCase
{
    use DatabaseTransactions;
    public const VALIDATION_ERROR_MESSAGE = 'Error de validació.';

    private $tag;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tag = Tag::first() ?? Tag::factory()->create(['tag_name' => 'Initial Tag Name']);
    }

    public function testUpdateTagSuccessfully()
    {
        $updatedTagName = 'Updated Tag Name';

        $response = $this->putJson(route('tag.update', ['tagId' => $this->tag->id]), [
            'tag_name' => $updatedTagName,
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'tag' => [
                'id' => $this->tag->id,
                'tag_name' => $updatedTagName,
            ],
        ]);
        $this->tag->refresh();

        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id,
            'tag_name' => $updatedTagName,
        ]);
        $this->assertEquals($updatedTagName, $this->tag->tag_name);
    }

    public function testAllowsToUpdateATagByUsingItsSameName(): void
    {
        $updatedTagName = $this->tag->tag_name;

        $response = $this->putJson(route('tag.update', ['tagId' => $this->tag->id]), [
            'tag_name' => $updatedTagName,
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'tag' => [
                'id' => $this->tag->id,
                'tag_name' => $updatedTagName,
            ],
        ]);
        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id,
            'tag_name' => $updatedTagName,
        ]);
        $this->assertEquals($updatedTagName, $this->tag->tag_name);
    }

    public function testUpdateTagFailsForNonExistentTag(): void
    {
        $nonExistentTagId = 0;

        $response = $this->putJson(route('tag.update', ['tagId' => $nonExistentTagId]), [
            'tag_name' => 'New Name',
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'No s\'ha trobat cap etiqueta amb aquest ID: ' . $nonExistentTagId,
        ]);
    }

    public function testReturnsUnprocessableContentWhenMissingTagName(): void
    {
        $response = $this->putJson(route('tag.update', ['tagId' => $this->tag->id]), [
            'tag_name' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => self::VALIDATION_ERROR_MESSAGE,
            'errors' => [
                'tag_name' => [
                    'El camp tag name és obligatori.',
                ],
            ],
        ]);
        $response->assertJsonValidationErrors(['tag_name']);
    }

    public function testUpdateTagFailsWhenTagNameIsInteger(): void
    {
        $response = $this->putJson(route('tag.update', ['tagId' => $this->tag->id]), [
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
        $response = $this->putJson(route('tag.update', ['tagId' => $this->tag->id]), [
            'tag_name' => str_repeat('a', 76),
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => self::VALIDATION_ERROR_MESSAGE,
            'errors' => [
                'tag_name' => [
                    'Tag name no pot ser més gran que 75 caràcters.',
                ],
            ],
        ]);
        $response->assertJsonValidationErrors(['tag_name']);
    }

    public function testReturnsUnprocessableContentWithDuplicateName(): void
    {
        $otherTag = Tag::find($this->tag->id + 1) ?? Tag::factory()->create(['tag_name' => 'Other Tag Name']);

        $response = $this->putJson(route('tag.update', ['tagId' => $otherTag->id]), [
            'tag_name' => $this->tag->tag_name,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => self::VALIDATION_ERROR_MESSAGE,
            'errors' => [
                'tag_name' => [
                    'Tag name ja està registrat i no es pot repetir.',
                ],
            ],
        ]);
        $response->assertJsonValidationErrors(['tag_name']);
    }

    public function testTagUpdateControllerCanBeInstantiated(): void
    {
        $tagUpdateService = $this->createMock(TagUpdateService::class);
        $controller = new TagUpdateController($tagUpdateService);
        $this->assertInstanceOf(TagUpdateController::class, $controller);
    }
}
