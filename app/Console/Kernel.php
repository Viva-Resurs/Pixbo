<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\GenerateShadows::class,
        \App\Console\Commands\ClearOldShadows::class,
        \App\Console\Commands\ClearShadows::class,
        \App\Console\Commands\GenerateACL::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('pixbo:generate-shadows')->after(function() {
            Log::info('ShadowEvents has been regenerated.');
        });
        /*
        $schedule->command('pixbo:generate-shadows')
            ->weekly()->sundays()->at('23:59')->after(function() {
                Log::info('ShadowEvents has been regenerated.');
            });
        */

    }
}
