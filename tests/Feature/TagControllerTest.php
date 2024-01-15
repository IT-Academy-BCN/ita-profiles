<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\TagFactory;
use Tests\TestCase;
use App\Models\Tag;
use App\Models\User;
use Spatie\Permission\Models\Role;


class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    // Create admin user with role and authenticate
    protected function createAndAuthenticateAdmin()
    {
        $user = User::factory()->create();
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            // If the "admin" role does not exist, create it
            $adminRole = Role::create(['name' => 'admin']);
        }

        $user->assignRole($adminRole);
        $this->actingAs($user, 'api');

        return $user;
    }

    public function testIndexReturnsTags()
    {
        // Create an admin user and authenticate
        $this->createAndAuthenticateAdmin();

        // Create some tags
        TagFactory::new()->count(3)->create();

        $response = $this->json('GET', '/api/v1/tags');

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
        $this->createAndAuthenticateAdmin();

        $response = $this->json('GET', '/api/v1/tags');

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No hi ha tags a la base de dades']);
    }

    public function testStoreTag()
    {
        $this->createAndAuthenticateAdmin();

        $tagData = Tag::factory()->make()->toArray();

        $response = $this->json('POST', '/api/v1/tags', $tagData);

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
        $this->createAndAuthenticateAdmin();

        $response = $this->json('POST', '/api/v1/tags', []);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'tag_name'
            ]
        ]);

        $response->assertJsonFragment([
            'tag_name' => ['El camp tag name és obligatori.'],
        ]);
    }

    public function testShowReturnsTag()
    {
        $this->createAndAuthenticateAdmin();

        $tag = Tag::factory()->create();

        $response = $this->json('GET', "/api/v1/tags/{$tag->id}");

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
        $this->createAndAuthenticateAdmin();

        $tag = Tag::factory()->create();

        $updatedData = [
            'tag_name' => 'Updated Tag Name',
        ];

        $response = $this->json('PUT', "/api/v1/tags/{$tag->id}", $updatedData);

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
        $this->createAndAuthenticateAdmin();

        $tag = Tag::factory()->create();

        $response = $this->json('DELETE', "/api/v1/tags/{$tag->id}");

        $response->assertStatus(200);

        $response->assertJson(['message' => __('Tag deleted successfully')]);

        // Attempt to retrieve the deleted tag from the database
        $retrievedTag = Tag::find($tag->id);

        // Assert that the tag has been deleted
        $this->assertNull($retrievedTag);
    }
}