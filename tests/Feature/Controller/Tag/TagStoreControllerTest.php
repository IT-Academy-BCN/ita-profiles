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

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testTagStoreControllerReturns_201StatusWhenNewTagDataIsValid(): void
    {
        $tagData = ['tag_name' => 'Test Tag'];

        $response = $this->postJson(route('tag.create'), $tagData);

        $response->assertStatus(201);

        $response->assertJson([
            'data' => [
                'tag_name' => 'Test Tag'
            ],
            'message' => 'Tag creada amb èxit.'
        ]);

        $this->assertDatabaseHas('tags', ['tag_name' => 'Test Tag']);
    }

    public function testTagStoreControllerReturns_422StatusWhenNewRequiredFieldIsMissing(): void
    {
        $tagData = [];

        $response = $this->postJson(route('tag.create'), $tagData);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['tag_name']);
    }

    public function testTagStoreControllerReturns_422StatusWhenMaxLengthExceeded(): void
    {
        $tagData = ['tag_name' => str_repeat('a', 76)];

        $response = $this->postJson(route('tag.create'), $tagData);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['tag_name']);
    }

    public function testTagStoreControllerReturns_422StatusWhenTagAlreadyExists(): void
    {
        Tag::create(['tag_name' => 'Existing Tag']);

        $tagData = ['tag_name' => 'Existing Tag'];

        $response = $this->postJson(route('tag.create'), $tagData);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['tag_name']);
    }
    
    public function testTagListControllerCanBeInstantiated(): void
    {
        $tagStoreService = $this->createMock(TagStoreService::class);
        
        $controller = new TagStoreController($tagStoreService);

        $this->assertInstanceOf(TagStoreController::class, $controller);
    }
}