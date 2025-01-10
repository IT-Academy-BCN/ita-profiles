<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Message;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Laravel\Passport\Passport;

class SendMessageTest extends TestCase
{
    use DatabaseTransactions;

    private $sender;
    private $receiver;

    protected function setUp(): void
    {
        parent::setUp();


        $this->sender = User::factory()->create();
        $this->receiver = User::factory()->create();

        // Authenticate sender
        Passport::actingAs($this->sender);
    }

    public function testUserCanSendMessageSuccessfully()
    {
        $response = $this->postJson(route('message.send'), [
            'subject' => 'Hello!',
            'body' => 'This is a test message.',
            'receiver_id' => $this->receiver->id,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('messages', [
            'receiver_id' => $this->receiver->id,
            'subject' => 'Hello!',
            'body' => 'This is a test message.',
            'read' => false,
        ]);
    }

    public function testMessageRequiresSubjectAndBodyFields()
    {
        $response = $this->postJson(route('message.send'), [
            'receiver_id' => $this->receiver->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject', 'body']);
    }

    public function testSubjectExceeds255Characters()
    {
        $response = $this->postJson(route('message.send'), [
            'subject' => str_repeat('A', 256),
            'body' => 'This is a test message.',
            'receiver_id' => $this->receiver->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject']);
    }

    public function testReceiverIsInvalid()
    {
        $response = $this->postJson(route('message.send'), [
            'subject' => 'Invalid Receiver Test',
            'body' => 'Testing receiver validation.',
            'receiver_id' => 'invalid-uuid',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['receiver_id']);
    }

    public function testBodyFieldIsEmpty()
    {
        $response = $this->postJson(route('message.send'), [
            'subject' => 'Empty Body Test',
            'body' => '',
            'receiver_id' => $this->receiver->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['body']);
    }

    public function testSubjectFieldIsEmpty()
    {
        $response = $this->postJson(route('message.send'), [
            'subject' => '',
            'body' => 'This is a message with an empty subject.',
            'receiver_id' => $this->receiver->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subject']);
    }
}
