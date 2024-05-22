<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Database\Factories\TagFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    // ESTE MÉTODO DEBERÍA ELIMINARSE. YA EXISTE EL TAGLISTCONTROLLER
    /* public function testIndexReturnsTags()
    {
       
        $tags = Tag::query()->limit(3)->get();

        if ($tags->count() < 3) {
            $tags = TagFactory::new()->count(3 - $tags->count())->create();
        }

        $response = $this->getJson(route('tag.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'tag_name',
                ],
            ],
        ]);
    } */

    // ESTE MÉTODO DEBERÍA ELIMINARSE. NO DEBE DEVOLVER UN ERROR, SINO UN ARRAY VACÍO
    /* public function testIndexReturns404WhenNoTagsExist()
    {
        // Delete all existing tags from the database
        Tag::query()->delete();

        $response = $this->getJson(route('tag.index'));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'Not found']);
    } */

    public function testStoreTag()
    {
        // Delete all existing tags from the database
        Tag::query()->delete();

        $tagData = Tag::factory()->make()->toArray();

        $response = $this->postjson(route('tag.create'), $tagData);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'tag_name',
            ],
            'message',
        ]);
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

}
