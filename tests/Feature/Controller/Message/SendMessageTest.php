<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Message;

use App\Models\User;
use App\Models\Student;
use App\Models\Recruiter;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_message_successfully()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $this->actingAs($sender);
        
        $response = $this->postJson(route('message.send'), [
            'subject' => 'Hello!',
            'body' => 'This is a test message.',
            'receiver_id' => $receiver->id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'sender' => $sender->id,
            'receiver' => $receiver->id,
            'subject' => 'Hello!',
            'body' => 'This is a test message.',
            'read' => false,
        ]);
    }
    public function test_message_requires_subject_and_body_fields()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson(route('message.send'), [
            'receiver' => $receiver->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject', 'body']);
    }
    public function test_subject_exceeds_255_characters()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson(route('message.send'), [
            'subject' => str_repeat('A', 256), // 256 characters
            'body' => 'This is a test message.',
            'receiver' => $receiver->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject']);
    }
    public function test_receiver_is_invalid()
    {
        $sender = User::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson(route('message.send'), [
            'subject' => 'Invalid Receiver Test',
            'body' => 'Testing receiver validation.',
            'receiver' => 'invalid-uuid', // Invalid UUID
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['receiver_id']);
    }
    public function test_body_field_is_empty()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson(route('message.send'), [
            'subject' => 'Empty Body Test',
            'body' => '', // Empty body
            'receiver' => $receiver->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['body']);
    }
    public function test_subject_field_is_empty()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson(route('message.send'), [
            'subject' => '', // Empty subject
            'body' => 'This is a message with an empty subject.',
            'receiver' => $receiver->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject']);
    }
      
}