<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Tag;
use App\Http\Controllers\api\Tag\TagListController;
use App\Service\TagListService;

class TagListControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $tagListService;

    protected function setUp(): void
    {
        parent::setUp();

        Tag::query()->delete();
    }

    public function testTagListControllerReturnsA_200ResponseWhenTagTableHasTags(): void
    {
        Tag::factory()->count(26)->create();

        $response = $this->getJson(route('tag.list'));

        $response->assertStatus(200);
    }

    public function testTagListControllerReturnsA_200ResponseWhenTagTableHasNoTags(): void
    {
        $response = $this->getJson(route('tag.list'));

        $response->assertStatus(200);
    }

    public function testTagListControllerCanBeInstantiated(): void
    {
        $tagListService = $this->createMock(TagListService::class);
        
        $controller = new TagListController($tagListService);

        $this->assertInstanceOf(TagListController::class, $controller);
    }
}
