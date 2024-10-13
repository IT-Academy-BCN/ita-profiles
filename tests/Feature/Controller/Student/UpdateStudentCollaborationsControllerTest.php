<?php

namespace Tests\Feature\Http\Controllers\api\Student;

use Tests\TestCase;
use App\Models\Resume;
use App\Models\Student;
use App\Models\Collaboration;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateStudentCollaborationsControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private Student $student;
    private Resume $resume;
    private array $collaborations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::has('resume')->first();
        if (!$this->student) {
            $this->student = Student::factory()->create();
            $this->resume = Resume::factory()->create(['student_id' => $this->student->id]);
        } else {
            $this->resume = $this->student->resume;
        }

        $existingCollaborations = Collaboration::take(3)->get();
        if ($existingCollaborations->count() < 3) {
            $newCollaborations = Collaboration::factory()->count(3 - $existingCollaborations->count())->create();
            $this->collaborations = $existingCollaborations->concat($newCollaborations)->pluck('id')->toArray();
        } else {
            $this->collaborations = $existingCollaborations->pluck('id')->toArray();
        }
    }

    public function testCanUpdateStudentCollaborations(): void
    {
        $response = $this->putJson(
            route('student.updateCollaborations', $this->student),
            ['collaborations' => $this->collaborations]
        );

        $response->assertOk()
            ->assertJson(['message' => 'Collaborations updated']);

        $expectedIds = collect($this->collaborations)->sort()->values()->toArray();
        $actualIds = $this->resume->fresh()->collaborations()->pluck('collaborations.id')->sort()->values()->toArray();

        $this->assertEquals($expectedIds, $actualIds);
    }

    public function testCanRemoveAllCollaborations(): void
    {
        $this->resume->collaborations()->sync($this->collaborations);

        $this->assertNotEmpty($this->resume->fresh()->collaborations()->get());

        $response = $this->putJson(
            route('student.updateCollaborations', $this->student),
            ['collaborations' => []]
        );

        $response->assertOk();
        $this->assertEmpty($this->resume->fresh()->collaborations()->get());
    }

    public function testValidatesCollaborationsMustBeArray(): void
    {
        $response = $this->putJson(
            route('student.updateCollaborations', $this->student),
            ['collaborations' => 'not-an-array']
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['collaborations']);
    }

    public function testValidatesCollaborationsAreRequired(): void
    {
        $response = $this->putJson(
            route('student.updateCollaborations', $this->student),
            []
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['collaborations']);
    }

    public function testAllowsNullValuesInCollaborationsArray(): void
    {
        $validCollaborations = collect($this->collaborations)->filter()->values()->toArray();
        $collaborationsWithNull = array_merge($validCollaborations, [null]);

        $response = $this->putJson(
            route('student.updateCollaborations', $this->student),
            ['collaborations' => $collaborationsWithNull]
        );

        $response->assertOk();

        $actualIds = $this->resume->fresh()->collaborations()->pluck('collaborations.id')->sort()->values()->toArray();
        $expectedIds = collect($validCollaborations)->sort()->values()->toArray();

        $this->assertEquals($expectedIds, $actualIds);
    }

    public function testFailsWhenStudentHasNoResume(): void
    {
        $this->assertNotEmpty($this->collaborations, 'No hay colaboraciones disponibles para la prueba');

        $studentWithoutResume = Student::factory()->create();

        $response = $this->putJson(
            route('student.updateCollaborations', $studentWithoutResume),
            ['collaborations' => $this->collaborations]
        );

        $response->assertNotFound();
    }
}
