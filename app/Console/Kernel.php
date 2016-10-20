<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\GenerateAllEventShadows;
use App\Console\Commands\ClearOldEventShadows;
use App\Console\Commands\ClearAllEventShadows;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        GenerateAllEventShadows::class,
        ClearOldEventShadows::class,
        ClearAllEventShadows::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $schedule->command('pixbo:generate-new-shadowevents')
            ->weekly()->sundays()->at('23:59')->after(function() {
                Log::info('ShadowEvents has been regenerated.');
            });
        
    }
}
