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
        $receiver = Student::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson('/api/messages', [
            'subject' => 'Hello there!',
            'body' => 'Just wanted to reach out to you.',
            'receiver_id' => $receiver->id,
            'receiver_type' => 'student',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Message sent successfully']);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'sender_type' => User::class,
            'receiver_id' => $receiver->id,
            'receiver_type' => Student::class,
            'subject' => 'Hello there!',
            'body' => 'Just wanted to reach out to you.',
        ]);
    }

    public function test_message_requires_subject_and_body_fields()
    {
        $sender = User::factory()->create();
        $receiver = Recruiter::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson('/api/messages', [
            'receiver_id' => $receiver->id,
            'receiver_type' => 'recruiter',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject', 'body']);
    }

    public function test_invalid_receiver_type_returns_error()
    {
        $sender = User::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson('/api/messages', [
            'subject' => 'Invalid receiver type test',
            'body' => 'Testing with an invalid type',
            'receiver_id' => 'some-uuid',
            'receiver_type' => 'invalidType',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['receiver_type']);
    }

    public function test_guest_cannot_send_message()
    {
        $receiver = User::factory()->create();

        $response = $this->postJson('/api/messages', [
            'subject' => 'Unauthorized attempt',
            'body' => 'Trying to send a message as guest',
            'receiver_id' => $receiver->id,
            'receiver_type' => 'user',
        ]);

        $response->assertStatus(401);
    }
}