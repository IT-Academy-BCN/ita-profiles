<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Message;

use App\Models\User;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_message_successfully()
    {
        // Create sender and receiver users
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        // Act as the sender
        $this->actingAs($sender);

        // Send a POST request to send a message
        $response = $this->postJson("/api/messages/{$receiver->id}", [
            'subject' => 'Hello there!',
            'body' => 'Just wanted to reach out to you.',
        ]);

        // Assert successful response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Message sent successfully',
        ]);

        // Verify that the message was stored in the database
        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'subject' => 'Hello there!',
            'body' => 'Just wanted to reach out to you.',
        ]);
    }

    public function test_message_requires_subject_and_body_fields()
    {
        // Create sender and receiver users
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        // Act as the sender
        $this->actingAs($sender);

        // Send an empty message payload to test validation
        $response = $this->postJson("/api/messages/{$receiver->id}", []);

        // Assert validation errors for missing fields
        $response->assertStatus(422); // Unprocessable Entity
        $response->assertJsonValidationErrors(['subject', 'body']);
    }

    public function test_invalid_receiver_id_returns_not_found_error()
    {
        // Create a sender
        $sender = User::factory()->create();

        // Act as the sender
        $this->actingAs($sender);

        // Attempt to send a message to a non-existent user ID
        $invalidReceiverId = 9999;
        $response = $this->postJson("/api/messages/{$invalidReceiverId}", [
            'subject' => 'Hello!',
            'body' => 'Message content.',
        ]);

        // Assert not found error response
        $response->assertStatus(404); // Not Found
    }

    public function test_guest_cannot_send_message()
    {
        // Create a receiver
        $receiver = User::factory()->create();

        // Attempt to send a message as a guest
        $response = $this->postJson("/api/messages/{$receiver->id}", [
            'subject' => 'Guest attempt',
            'body' => 'This should not go through.',
        ]);

        // Assert unauthorized error response
        $response->assertStatus(401); // Unauthorized
    }
}
