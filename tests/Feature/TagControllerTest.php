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

        $user = User::first();

        if (!$user) {
            // If there are no users, create one
            $user = User::factory()->create();
        }
        
        $adminRole = Role::where('name', 'admin')->first();

        if (! $adminRole) {
            // If the "admin" role does not exist, create it
            $adminRole = Role::create(['name' => 'admin']);
        }

        $user->assignRole($adminRole);
        $this->actingAs($user, 'api');
    }

    public function testIndexReturnsTags()
    {
       
        // Retrieve three existing tags from the database
        $tags = Tag::query()->limit(3)->get();

        // If there are fewer than three tags in the database, create the necessary ones
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
    }

    public function testIndexReturns404WhenNoTagsExist()
    {
        // Delete all existing tags from the database
        Tag::query()->delete();

        $response = $this->getJson(route('tag.index'));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'Not found']);
    }

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

    public function testShowReturnsTag()
    {
        $tag = Tag::query()->first();

        $response = $this->getJson(route('tag.show', ['id' => $tag->id]));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'tag_name',
            ],
        ]);

        // Assert the response data matches the created tag
        $response->assertJson([
            'data' => [
                'id' => $tag->id,
                'tag_name' => $tag->tag_name,
            ],
        ]);
    }

    public function testUpdateTagSuccessfully()
    {
        $tag = Tag::query()->first();

        $updatedData = [
            'tag_name' => 'Updated Tag Name',
        ];

        $response = $this->putJson(route('tag.update', ['id' => $tag->id]), $updatedData);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'tag_name',
            ],
            'message',
        ]);

        $response->assertJson([
            'data' => [
                'id' => $tag->id,
                'tag_name' => $updatedData['tag_name'],
            ],
            'message' => __('Tag updated successfully'),
        ]);

        // Refresh the tag from the database
        $tag->refresh();

        // Assert the tag in the database has been updated
        $this->assertEquals($updatedData['tag_name'], $tag->tag_name);
    }

    public function testDestroyTagSuccessfully()
    {
        $tag = Tag::query()->first();

        $response = $this->deleteJson(route('tag.destroy', ['id' => $tag->id]));

        $response->assertStatus(200);

        $response->assertJson(['message' => __('Tag deleted successfully')]);

        // Attempt to retrieve the deleted tag from the database
        $retrievedTag = Tag::find($tag->id);

        // Assert that the tag has been deleted
        $this->assertNull($retrievedTag);
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
