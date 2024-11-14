<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;


use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\JobOffer;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Api\Job\JobOfferController;

class JobOfferCommandTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function testIfJobOfferModelExists(): void
    {
        $this->assertTrue(class_exists(JobOffer::class));
    }
    public function testIfJobOfferControllerExists(): void
    {
        $this->assertTrue(class_exists(JobOfferController::class));
    }
    public function testCreateJobOfferWithValidParameters()
    {
        // Crear un usuario con el factory
        $user = User::factory()->create();
        // Generar un email único usando un sufijo aleatorio o incremental
        $uniqueEmail = 'company' . uniqid() . '@example.com';
        $uniqueCif = 'A' . uniqid();

        // Crear una compañía manualmente
        $company = Company::create([
            'name' => 'Test Company',
            'location' => 'Test Location',
            'email' => $uniqueEmail,
            'CIF' => $uniqueCif,
            'website' => 'https://company.com',
        ]);

        // Crear un reclutador manualmente y asociarlo a la compañía y al usuario
        $recruiter = Recruiter::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'name' => 'Recruiter Name',
            'email' => 'recruiter@example.com',
            'role' => 'Recruiter',
        ]);

        // Ejecutar el comando Artisan para crear una oferta de trabajo
        $exitCode = Artisan::call('job:offer:create', [
            'recruiter_id' => $recruiter->id,
            'title' => 'Software Engineer',
            'description' => 'Looking for a Software Engineer.',
            'location' => 'Remote',
            'skills' => 'PHP, Laravel, JavaScript',
            'salary' => 25000
        ]);

        // Verificar que el comando se ejecutó correctamente
        $this->assertEquals(0, $exitCode);

        // Asegurarse de que la oferta de trabajo se insertó correctamente
        $this->assertDatabaseHas('job_offers', [
            'title' => 'Software Engineer',
            'salary' => 25000,
            'recruiter_id' => $recruiter->id,
            'description' => 'Looking for a Software Engineer.',
            'location' => 'Remote',
            'skills' => 'PHP, Laravel, JavaScript'
        ]);

        // Verificar que la compañía se insertó correctamente
        $this->assertDatabaseHas('companies', [
            'email' => $uniqueEmail,  // Verificar que la compañía tiene el email correcto
        ]);
    }
}
