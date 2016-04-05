<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Log;

class Kernel extends ConsoleKernel {
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		\App\Console\Commands\Inspire::class,
		\App\Console\Commands\ClearOldShadowEvents::class,
		\App\Console\Commands\ClearAllShadowEvents::class,
		\App\Console\Commands\GenerateNewShadowEvents::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule) {
		$schedule->command('pixbo:generate-new-shadowevents')
			->weekly()->sundays()->at('23:59')->after(function() {
				Log::info('ShadowEvents has been regenerated.');
			});
	}
}
