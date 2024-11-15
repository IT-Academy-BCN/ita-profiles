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
        
        $response = $this->postJson(route('message.send'), [
            'subject' => 'Hello!',
            'body' => 'This is a test message.',
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
            'subject' => 'Hello!',
            'body' => 'This is a test message.',
        ]);
    }
    public function test_message_requires_subject_and_body_fields()
    {
        $sender = User::factory()->create();
        $receiver = Student::factory()->create();

        $this->actingAs($sender);

        $response = $this->postJson(route('message.send'), [
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

        $response = $this->postJson(route('message.send'), [
            'subject' => 'Invalid receiver type test',
            'body' => 'Testing with an invalid type',
            'receiver_id' => 'some-uuid',
            'receiver_type' => 'invalidType',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['receiver_type']);
    }
    public function test_subject_exceeds_255_characters()
    {
        $sender = User::factory()->create();
        $receiver = Student::factory()->create();
    
        $this->actingAs($sender);
    
        $response = $this->postJson(route('message.send'), [
            'subject' => str_repeat('A', 256),
            'body' => 'Example body', // 256 characters
            'receiver_id' => $receiver->id,
            'receiver_type' => 'student',
        ]);
    
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject']);
    }
    public function test_receiver_id_is_not_a_uuid()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();
    
        $this->actingAs($sender);
    
        $response = $this->postJson(route('message.send'), [
            'subject' => 'Non-UUID Receiver ID Test',
            'body' => 'Testing receiver ID format validation.',
            'receiver_id' => 'not-a-uuid', // Invalid UUID
            'receiver_type' => 'user',
        ]);
    
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['receiver_id']);
    }
    public function test_invalid_receiver_type()
    {
        $sender = User::factory()->create();
        $receiver = Student::factory()->create();
    
        $this->actingAs($sender);
    
        $response = $this->postJson(route('message.send'), [
            'subject' => 'Invalid Receiver Type Test',
            'body' => 'Testing invalid receiver type validation.',
            'receiver_id' => $receiver->id,
            'receiver_type' => 'admin', // Invalid receiver type
        ]);
    
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['receiver_type']);
    }
    public function test_body_field_is_empty()
    {
        $sender = User::factory()->create();
        $receiver = Student::factory()->create();
    
        $this->actingAs($sender);
    
        $response = $this->postJson(route('message.send'), [
            'subject' => 'Empty Body Test',
            'body' => '', // Empty body
            'receiver_id' => $receiver->id,
            'receiver_type' => 'student',
        ]);
    
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['body']);
    }
    public function test_subject_field_is_empty()
    {
        $sender = User::factory()->create();
        $receiver = Student::factory()->create();
    
        $this->actingAs($sender);
    
        $response = $this->postJson(route('message.send'), [
            'subject' => '', // Empty subject
            'body' => 'This is a message with an empty subject.',
            'receiver_id' => $receiver->id,
            'receiver_type' => 'student',
        ]);
    
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject']);
    }
    
    
    
    
    
    

   
}