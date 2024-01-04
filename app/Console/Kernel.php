<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->exec('bash ./scripts/gitPull.sh')
            ->hourly()
            ->sendOutputTo(storage_path('logs/gitPull.log'));
        $schedule->exec('python3 ./scripts/checkRepo.py')
            ->hourly()
            ->sendOutputTo(storage_path('logs/checkRepo.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
