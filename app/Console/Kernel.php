<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
        /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\CreateJobOfferCommand::class,
    ];
    
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('project:execute-project-processing-service')
            ->dailyAt('3:00')
            ->appendOutputTo('./storage/logs/cron.log');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
