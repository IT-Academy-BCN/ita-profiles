<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class KernelScheduleTest extends TestCase
{
    use DatabaseTransactions;
    public function testScheduleContainsExecuteProjectProcessingServiceCommand()
    {
        $schedule = $this->app->make(Schedule::class);

        $events = collect($schedule->events())->filter(function ($event) {
            return str_contains($event->command, 'project:execute-project-processing-service');
        });

        // Verificar que el comando está programado para ejecutarse
        $this->assertNotEmpty($events, 'The command project:execute-project-processing-service is not scheduled.');

        // Verifica la hora y salida programadas
        $events->each(function ($event) {
            $this->assertStringContainsString('project:execute-project-processing-service', $event->command);
            $this->assertStringContainsString('./storage/logs/cron.log', $event->output);
        });
    }
}
